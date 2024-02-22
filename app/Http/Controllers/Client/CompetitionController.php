<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\PlatformController;
use App\Models\Competition\CompetitionGame;
use App\Models\Competition\CompetitionRoom;
use App\Models\Competition\CompetitionRule;
use App\Models\Member\MemberCompetition;
use App\Models\User;
use App\Service\Competition\CompetitionEventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompetitionController extends PlatformController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['games', 'rules', 'rooms']]);
    }

    /**
     * 游戏列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function games(Request $request)
    {
        $res = (new CompetitionGame())->searchBuild(['show' => 1])->orderBy('sort_order')->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function parentGames(Request $request)
    {
        $res = (new CompetitionGame())->searchBuild([])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rules(Request $request)
    {
        $game_id = $request->input('game_id');
        $res = (new CompetitionRule())
            ->searchBuild(['game_id' => $game_id], ['competitionGame', 'unit'])
            ->select(['id', 'title', 'unit_id', 'game_id'])
            ->orderBy('sort_order')
            ->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * 房间列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function rooms(Request $request)
    {
        $param = $request->all();
        $param['started_at'] = time();
        $param['status'] = CompetitionRoom::STARTING_STAGE;

        $res = (new CompetitionRoom())
            ->searchBuild($param, ['competitionRule'])
            ->where('started_at', '>', time())
            ->orderBy('started_at')
            ->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * 房间详情
     * @return \Illuminate\Http\JsonResponse
     */
    public function roomDetails(Request $request)
    {
        $user = auth('api')->user();
        if ($member_id = $user->getMemberID()) {
            if ($id = $request->input('room_id')) {
                if ($model = CompetitionRoom::findOneByID($id, ['competitionRule.prizes.goods', 'participants'])) {
                    $res_array = $model->toArray();
                    if (!empty($res_array['participants'])) {

                        $res_array['join_type'] = null;

                        foreach ($res_array['participants'] as $participant) {
                            if ($participant['member_id'] === $member_id) {
                                $res_array['join_type'] = [
                                    'team' => $participant['team_index']
                                ];
                            }
                        }
                    }
                    return self::successJsonResponse($res_array);
                }
            }
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * 当前加入房间
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentJoinRoom()
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member_id = $user->getMemberID()) {
            if ($memberCompetition = MemberCompetition::alreadyInRoom($member_id, ['room'])) {
                $join_members = MemberCompetition::totalCount($memberCompetition->room->id);
                foreach ($join_members as $join_member) {
                    CompetitionEventService::setRoom($memberCompetition->room, $join_members->count(), $join_member->team_index, "join_room_{$join_member->member_id}");
                }
                return self::successJsonResponse($memberCompetition->room);
            }
            return self::failJsonResponse("未加入房间");
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * 参加比赛
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function joinRoom(Request $request)
    {

        if ($id = $request->input('room_id')) {
            /** @var User $user */
            $user = auth('api')->user();
            if ($member_id = $user->getMemberID()) {
                if ($user->member->isBlock()) {
                    return self::failJsonResponse("会员账户已封锁");
                }
                DB::beginTransaction();
                try {
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

        return self::failJsonResponse("未获取到相关数据");
    }

}
