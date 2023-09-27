<?php

namespace App\Http\Controllers\Backend\Quest;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Quest\Quest;
use Illuminate\Http\Request;

class QuestController extends PlatformController
{
    protected $controller_event_text = "任务管理";

    public function index(Request $request){
        $res = (new Quest())->searchBuild($request->all())->paginate();
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
                    'title' => 'required',
                ]);

                if ($id > 0) {
                    $model = Quest::findOneByID($id);
                } else {
                    $model = new Quest();
                }

                if ($model->fill($request->all())->save()) {
                    $this->saveEvent($model->title);
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
        if ($request->isMethod('POST') && $id = $request->input('id')) {
            if ($model = Quest::findOneByID($id)) {
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
            if ($model = Quest::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
