<?php

namespace App\Http\Controllers\Backend\Competition;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Competition\CompetitionGameTeam;
use Illuminate\Http\Request;

class CompetitionGameTeamController extends PlatformController
{
    protected $controller_event_text = "比赛游戏队伍";

    public function index(Request $request){
        $res = (new CompetitionGameTeam())->searchBuild($request->all())->paginate();
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
                    'title' => 'required',
                    'member_id' => 'required',
                ]);

                if ($id > 0) {
                    $model = CompetitionGameTeam::findOneByID($id);
                } else {
                    $model = new CompetitionGameTeam();
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
            if ($model = CompetitionGameTeam::findOneByID($id)) {
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
            if ($model = CompetitionGameTeam::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
