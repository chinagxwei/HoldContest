<?php

namespace App\Http\Controllers\Backend\Competition;

use App\Http\Controllers\PlatformController;
use App\Models\Competition\CompetitionRoom;
use App\Models\Competition\CompetitionRoomLink;
use App\Models\Competition\CompetitionRule;
use App\Models\Member\MemberCompetition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class CompetitionRoomLinkController extends PlatformController
{
    protected $controller_event_text = "比赛房间链接";

    public function index(Request $request)
    {
        $param = $request->all();
        $res = (new CompetitionRoom())->searchBuild($param, ['competitionRule'])
            ->where('ready_at', 0)
            ->where('started_at', 0)
            ->orderBy('game_room_code','desc')
            ->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableLinkNumber(Request $request)
    {
        if ($competition_rule_id = $request->input('competition_rule_id')) {
            $count = CompetitionRoom::getAvailableRoomNumber($competition_rule_id);
            return self::successJsonResponse([
                'count' => $count
            ]);
        }
        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastRoomSN(Request $request){
        if ($competition_rule_id = $request->input('competition_rule_id')) {
            $room = CompetitionRoom::getLastOne($competition_rule_id);
            if ($room){
                return self::successJsonResponse([
                    'game_room_code' => $room->game_room_code
                ]);
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
                    'urls' => 'required',
                    'competition_rule_id' => 'numeric',
                ]);
                $param = $request->all();

                $url_array = explode("\n", $param['urls']);

                $urls_key = array_map(function ($v) {
                    return [
                        'key' => md5($v),
                        'value' => $v
                    ];
                }, $url_array);

                $before_insert_urls = array_column($urls_key, 'value', 'key');

                $row = [];

                $user = auth('api')->user();

                $time = time();

                $competition_rule = CompetitionRule::findOneByID($param['competition_rule_id']);

                foreach ($before_insert_urls as $key => $url) {
                    $url_group = explode("｜", $url);
                    if (empty($url_group)) {
                        $url_group = explode("|", $url);
                        if (empty($url_group)) {
                            continue;
                        }
                    }
                    $item = [
                        'id' => Uuid::uuid4()->toString(),
                        'competition_rule_id' => $param['competition_rule_id'],
                        'game_room_code' => $url_group[0],
                        'game_room_name' => $url_group[0],
                        'quick' => $competition_rule->quick,
                        'link' => $url_group[1],
                        'link_hash' => $key,
                        'interval' => 0,
                        'ready_at' => 0,
                        'started_at' => 0,
                        'created_at' => $time,
                        'updated_at' => $time
                    ];
                    if (!empty($user)) {
                        $item['created_by'] = $user->id;
                        $item['updated_by'] = $user->id;
                    }
                    $row[] = $item;
                }

                if (count($row) === 0){
                    throw new \Exception("链接格式错误");
                }

                CompetitionRoom::query()->insertOrIgnore($row);

                foreach ($row as $value) {
                    $before_room = CompetitionRoom::findOneByID($value['id'], ['competitionRule']);
                    if (empty($before_room)) {
                        continue;
                    }
                    $reservation = [];

                    for ($i = 0; $i < $before_room->competitionRule->participants_number; $i++) {
                        $item2 = [
                            'game_room_id' => $value['id'],
                            'team_index' => ($i + 1),
                            'win' => 0,
                            'created_at' => $time,
                            'updated_at' => $time
                        ];

                        if (!empty($user)) {
                            $item2['created_by'] = $user->id;
                            $item2['updated_by'] = $user->id;
                        }
                        $reservation[] = $item2;
                    }
                    MemberCompetition::query()->insert($reservation);
                }

                DB::commit();
                return self::successJsonResponse();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return self::failJsonResponse($e->getMessage());
            }
        }
        return self::failJsonResponse();
    }

//    /**
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function delete(Request $request)
//    {
//        if ($id = $request->input('id')) {
//            if ($model = CompetitionRoomLink::findOneByID($id)) {
//                $this->deleteEvent($model->md5);
//                $model->delete();
//                return self::successJsonResponse();
//            }
//        }
//
//        return self::failJsonResponse();
//    }
}
