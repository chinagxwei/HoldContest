<?php

namespace App\Http\Controllers\Backend\Competition;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Competition\CompetitionGame;
use Illuminate\Http\Request;

class CompetitionGameController extends PlatformController
{
    protected $controller_event_text = "比赛游戏";

    public function index(Request $request){
        $res = (new CompetitionGame())->searchBuild($request->all())->paginate();
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
                    'game_name' => 'required',
                    'team_game' => 'numeric',
                    'quick' => 'numeric',
                    'participants_price' => 'numeric',
                    'participants_number' => 'numeric',
                    'start_number' => 'numeric',
                    'rule' => 'required',
                ]);

                if ($id > 0) {
                    $model = CompetitionGame::findOneByID($id);
                } else {
                    $model = new CompetitionGame();
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
            if ($model = CompetitionGame::findOneByID($id)) {
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
            if ($model = CompetitionGame::findOneByID($id)) {
                $this->deleteEvent($model->game_name);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
