<?php

namespace App\Service\Competition;

use App\Models\Competition\CompetitionRoom;
use App\Models\Competition\CompetitionRulePrize;
use App\Models\Member\Member;
use App\Models\Member\MemberCompetition;
use App\Models\Member\MemberGameAccount;
use App\Models\Order\Order;
use App\Service\Order\TradeService;
use App\Service\Wallet\PaymentService;
use App\Service\Wallet\RefundService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CompetitionEventService
{

    /**
     *
     * @param $member_id
     * @param $game_room_id
     * @return CompetitionRoom|bool|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     * @throws \Exception
     */
    public static function join($member_id, $game_room_id)
    {
        if (MemberCompetition::inCurrentRoom($member_id, $game_room_id)) {
            throw new \Exception('已经加入房间');
        } else {
            if ($memberCompetition = MemberCompetition::getEntryQuota($game_room_id, ['room.competitionRule'])) {
                if (empty($memberCompetition->room->competitionRule)) {
                    throw new \Exception('房间关联游戏失败');
                }
                if ($memberCompetition->room->started_at < time()) {
                    throw new \Exception('比赛已开始');
                }

                if ($memberCompetition->room->ready_at > time()){
                    $last_seconds = $memberCompetition->room->ready_at - time();
                    if ($last_seconds > (60 * 5)) {
                        throw new \Exception('开赛前5分钟开始报名');
                    }
                }

                // 判断是否有每日参与次数限制
                if ($memberCompetition->room->competitionRule->daily_participation_limit > 0) {
                    $dailyParticipation = MemberCompetition::dailyParticipation($member_id, $memberCompetition->room->competition_rule_id);
                    if ($dailyParticipation >= $memberCompetition->room->competitionRule->daily_participation_limit) {
                        throw new \Exception('今日可参与次数已达上限');
                    }
                }
                $price = $memberCompetition->room->competitionRule->participants_price;
                $unit_id = $memberCompetition->room->competitionRule->unit_id;
                if ($price <= 0) {
                    $memberCompetition->member_id = $member_id;
                    $memberCompetition->save();
                } else {
                    // 判断账户是否有钱，有钱支付并加入游戏，没钱显示余额不足
                    $member = Member::findOneByID($member_id, ['wallet.accounts']);
                    $account = $member->getUnitBalanceAccount($unit_id);
                    if ($account->balance->total_balance < $price) {
                        throw new \Exception('余额不足');
                    }
                    if ($account->balance->total_balance > $price) {
                        $order = Order::getCompetitionOrder($member_id, $price, $price, $unit_id);
                        $order->complete()->save();
                        $payment = new PaymentService();
                        // 生成扣款订单
                        if ($payment->setOrder($order)->setWallet($member->wallet)->execute()) {
                            $memberCompetition->from_order_sn = $order->sn;
                            $memberCompetition->member_id = $member_id;
                            $memberCompetition->save();
                        }
                    }
                }
                $join_members = MemberCompetition::totalCount($game_room_id);
                // 判断是否是快速比赛，是快速比赛满人变更房间状态
                if ($memberCompetition->room->isQuickRoom()) {

                    if ($join_members->count() >= $memberCompetition->room->competitionRule->start_number) {
                        $memberCompetition->room->setReviewStage()->save();
                    }
                }
                foreach ($join_members as $join_member) {
                    self::setRoom($memberCompetition->room, $join_members->count(), $join_member->team_index, "join_room_{$join_member->member_id}");
                }
                return true;
            }
            throw new \Exception('房间已满员');
        }
    }

    /**
     * @param CompetitionRoom $room
     * @return void
     */
    public static function setRoom($room, $join_number, $team_index, $currentRoomKey)
    {
        $cache_room_array = [
            'room_id' => $room->id,
            'room_name' => $room->game_room_name,
            'quick' => $room->quick,
            'team_game' => $room->competitionRule->team_game,
            'team_index' => $team_index,
            'team' => $room->competitionRule->team_game,
            'started_at' => $room->started_at,
            'link' => $room->link,
            'participants_number' => $room->competitionRule->participants_number,
            'start_number' => $room->competitionRule->start_number,
            'join_number' => $join_number,
        ];

        // 比赛开始后30秒参赛记录失效
        if (($cache_room_array['participants_number'] >= $cache_room_array['start_number']) && $cache_room_array['quick']) {
            $seconds = 30;
        } else {
            $seconds = $room->started_at - time() + 30;
        }

        Cache::put($currentRoomKey, json_encode($cache_room_array), now()->addSeconds($seconds));
    }

    /**
     * @param $competition_rule_id
     * @param $start_number
     * @return bool
     */
    public static function competitionRuleAfter($competition_rule_id, $start_number)
    {
        $prizeInsert = [];
        for ($i = 0; $i < $start_number; $i++) {
            $prizeInsert[] = [
                'competition_rule_id' => $competition_rule_id,
                'ranking' => $i + 1,
            ];
        }
        return CompetitionRulePrize::query()->insert($prizeInsert);
    }

    /**
     * @param CompetitionRoom $room
     * @return bool
     * @throws \Exception
     */
    public static function closeRoom($room)
    {
        if ($room->participants->count() >= $room->competitionRule->start_number) {
            Log::info("========= 参赛满人 =========");
            Log::info("========= 房间等待结果审核 =========");
            return $room->setReviewStage()->save();
        } else {
            Log::info("========= 参赛人数不足 =========");
            Log::info("========= 房间取消 =========");
            foreach ($room->participants as $participant) {
                (new RefundService())->setOrder($participant->fromOrder)->execute();
            }
            return $room->setCancelStage()->save();
        }
    }

    /**
     * @param $room_id
     * @return bool
     * @throws \Exception
     */
    public static function closeRoomByID($room_id)
    {
        Log::info("========= 房间ID [$room_id] =========");
        $room = CompetitionRoom::findUseOneByID($room_id, ['participants.fromOrder.member', 'competitionRule']);
        if (empty($room)) {
            throw new \Exception('房间不存在');
        }
        Log::info("========= 房间名称 [{$room->game_room_name}] =========");
        Log::info("========= 房间编号 [{$room->game_room_code}] =========");
        return self::closeRoom($room);
    }

    /**
     * @param $room_id
     * @param $win_member_id
     * @param $ranking
     * @param $win
     * @return bool
     * @throws \Exception
     */
    public static function roomSettlement($room_id, $win_member_id, $ranking, $win)
    {
        $room = CompetitionRoom::findOneByID($room_id, ['competitionRule.prizes']);

        $room->participants()
            ->where('member_id', $win_member_id)
            ->update([
                'win' => $win,
                'ranking' => $ranking,
                'complete_at' => time(),
            ]);

        $prize = $room->competitionRule->prizes()->where('ranking', $ranking)->first();

        if (!empty($prize->goods_id)) {
            TradeService::exchange($prize->goods_id, $win_member_id);
        }

        return $room->setEndStage()->save();
    }

    /**
     * @param $member_id
     * @param $game_id
     * @param $account_type
     * @param $nickname
     * @param $game_code
     * @return MemberGameAccount|void|null
     * @throws \Exception
     */
    public static function setGameAccount($member_id, $game_id, $account_type, $nickname, $game_code = null)
    {
        if ($member = Member::findOneByID($member_id)) {
            $isSet = $member->games()->where('game_id', $game_id)->where('account_type', $account_type)->exists();
            if ($isSet) {
                throw new \Exception("该类型已关联游戏账户");
            }

            return MemberGameAccount::generate($member_id, $game_id, $account_type, $nickname, $game_code);
        }

        throw new \Exception("会员无效");
    }
}
