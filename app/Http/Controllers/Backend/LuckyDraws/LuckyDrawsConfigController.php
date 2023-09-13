<?php

namespace App\Http\Controllers\Backend\LuckyDraws;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\LuckyDraws\LuckyDrawsConfig;
use Illuminate\Http\Request;

class LuckyDrawsConfigController extends PlatformController
{
    protected $controller_event_text = "获奖配置管理";

    public function index(Request $request){
        $res = (new LuckyDrawsConfig())->searchBuild($request->all())->paginate();
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
                    'total' => 'numeric',
                    'status' => 'numeric',
                    'started_at' => 'numeric',
                    'ended_at' => 'numeric',
                ]);

                if ($id > 0) {
                    $model = LuckyDrawsConfig::findOneByID($id);
                } else {
                    $model = new LuckyDrawsConfig();
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
        if ($request->isMethod('POST') && $id = intval($request->get('id'))) {
            if ($model = LuckyDrawsConfig::findOneByID($id)) {
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
            if ($model = LuckyDrawsConfig::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
