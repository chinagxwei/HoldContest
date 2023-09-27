<?php

namespace App\Http\Controllers\Backend\Competition;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Competition\CompetitionRoom;
use Illuminate\Http\Request;

class CompetitionRoomController extends PlatformController
{
    protected $controller_event_text = "比赛房间";

    public function index(Request $request){
        $res = (new CompetitionRoom())->searchBuild($request->all())->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = intval($request->get('id'));

            try {
                $this->validate($request, [
                    'game_id' => 'required',
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
    public function view(Request $request)
    {
        if ($request->isMethod('POST') && $id = intval($request->get('id'))) {
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
        if ($id = intval($request->get('id'))) {
            if ($model = CompetitionRoom::findOneByID($id)) {
                $this->deleteEvent($model->game_room_name);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
