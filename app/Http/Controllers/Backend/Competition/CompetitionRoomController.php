<?php

namespace App\Http\Controllers\Backend\Competition;

use App\Http\Controllers\PlatformController;
use App\Jobs\CloseCompetitionRoomJob;
use App\Models\ActionLog;
use App\Models\Competition\CompetitionRoom;
use App\Models\Competition\CompetitionRoomLink;
use App\Models\Competition\CompetitionRule;
use App\Models\Goods\Goods;
use App\Models\Member\MemberCompetition;
use App\Service\Competition\CompetitionEventService;
use App\Service\Wallet\RechargeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class CompetitionRoomController extends PlatformController
{
    protected $controller_event_text = "比赛房间";

    public function index(Request $request)
    {
        $res = (new CompetitionRoom())->searchBuild($request->all(), ['competitionRule', 'participants.member'])
            ->where('ready_at', '>', 0)
            ->where('started_at', '>', 0)
            ->orderBy('ready_at','desc')
            ->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = $request->input('id');

            try {
                $this->validate($request, [
                    'competition_rule_id' => 'required',
                    'game_room_name' => 'required',
                    'status' => 'numeric',
                    'quick' => 'numeric',
                    'complete' => 'numeric',
                    'game_room_qrcode' => 'required',
                    'interval' => 'numeric',
                    'ready_at' => 'numeric',
                    'started_at' => 'numeric',
                    'ended_at' => 'numeric',
                ]);

                if ($id > 0) {
                    $model = CompetitionRoom::findOneByID($id);
                } else {
                    $model = new CompetitionRoom();
                }

                if ($model->fill($request->all())->save()) {
                    $this->saveEvent($model->game_name);
                    return self::successJsonResponse();
                }
            } catch (\Exception $e) {
                return self::failJsonResponse($e->getMessage());
            }
        }
        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickAdd(Request $request)
    {
        if ($request->isMethod('POST')) {

            DB::beginTransaction();
            try {
                $this->validate($request, [
                    'competition_rule_id' => 'required',
                    'total' => 'required',
                    'interval' => 'numeric',
                    'start_second' => 'numeric',
                    'end_second' => 'numeric',
                ]);
                $param = $request->all();

                $competition_rule = CompetitionRule::findOneByID($param['competition_rule_id']);

                $count = CompetitionRoom::getAvailableRoomNumber($param['competition_rule_id']);

                if ($param['total'] <= $count) {

                    $time = time();

                    $links = CompetitionRoom::getAvailableRooms($param['competition_rule_id'], $param['total']);

                    $today = strtotime(date('Ymd'));

                    if (!empty($param['start_second'])) {
                        $param['start_second'] = intval($param['start_second']) - $today;
                    }

                    if (!empty($param['end_second'])) {
                        $param['end_second'] = intval($param['end_second']) - $today;
                    }

                    $endTime = $today + (empty($param['end_second']) ? $competition_rule->default_end_second : $param['end_second']);

                    $todayStartAt = $today + (empty($param['start_second']) ? $competition_rule->default_start_second : $param['start_second']);

                    $startTime = max($todayStartAt, $time);

                    $index = 0;

                    foreach ($links as $key => $link) {
                        $ready_at = $startTime + ($index + 1) * $param['interval'] * 60;
                        if ($ready_at > $endTime) {
                            $index = 0;

                            $nextDay = strtotime(date('Ymd') . ' +1 day');

                            $startTime = $nextDay + $competition_rule->default_start_second;

                            $endTime = $nextDay + $competition_rule->default_end_second;
                        }
                        $ready_at = $startTime + ($index + 1) * $param['interval'] * 60;
                        $index = $index + 1;
                        $link->interval = $param['interval'];
                        $link->ready_at = $ready_at;
                        $link->started_at = $ready_at + (60 * 10);
                        $link->save();

                        if ($dispatch = CloseCompetitionRoomJob::dispatch($link->id)) {
                            $seconds = $link->started_at - time() + 3;
                            Log::info("=== " . date("Y-m-d H:i:s", $link->started_at) . ": 延迟: $seconds 秒===");
                            $dispatch->onQueue('defaultQueue')->delay(now()->addSeconds($seconds));
                        }
                        $this->saveEvent($link->game_room_name);
                    }

                    DB::commit();
                    return self::successJsonResponse();
                } else {
                    throw new \Exception('链接库存数量不足');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return self::failJsonResponse($e->getMessage());
            }
        }
        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        if ($request->isMethod('POST') && $id = $request->input('id')) {
            if ($model = CompetitionRoom::findOneByID($id)) {
                return self::successJsonResponse($model);
            }
        }

        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        if ($id = $request->input('id')) {
            if ($model = CompetitionRoom::findOneByID($id)) {
                $this->deleteEvent($model->game_room_name);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse|void
     */
    public function join(Request $request)
    {
        if ($id = $request->input('id')) {
            DB::beginTransaction();
            try {
                $member_id = $request->input('member_id');
                CompetitionEventService::join($member_id, $id);
                DB::commit();
                return self::successJsonResponse();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return self::failJsonResponse($e->getMessage());
            }
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function settlement(Request $request)
    {
        if ($id = $request->input('id')) {

            if ($model = CompetitionRoom::findOneByID($id)) {
                DB::beginTransaction();
                try {
                    $prizes = $request->input('prizes');
                    $prizes_keys = array_filter(array_keys($prizes), function ($v) {
                        return is_numeric($v);
                    });
                    $set_index = 0;
                    foreach ($prizes_keys as $value) {

                        $log = MemberCompetition::findOneByID($value);

                        if (intval($prizes[$value]) === -1 || intval($prizes[$value]) === 1) {
                            if (!empty($prizes["value_{$value}"])) {
                                $goods = Goods::findOneByID($prizes["value_{$value}"]);
                                if ($goods) {
                                    $order_sn = RechargeService::exchangeRechargeCard($goods->relation_id, $log->member_id);
                                    $log->setWin($prizes[$value], $order_sn)->save();
                                }
                            }
                        } else {
                            if (!isset($prizes[$value])) {
                                continue;
                            }
                            $log->setWin($prizes[$value])->save();
                        }
                        $set_index = $set_index + 1;
                    }
                    if ($set_index > 0) {
                        $model->setEndStage()->save();
                    }

                    DB::commit();
                    return self::successJsonResponse();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());
                    return self::failJsonResponse($e->getMessage());
                }

            }
        }

        return self::failJsonResponse();
    }
}
