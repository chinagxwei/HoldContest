<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\PlatformController;
use App\Models\System\SystemConfig;
use Illuminate\Http\Request;

class SystemConfigController extends PlatformController
{
    protected $controller_event_text = "平台系统配置";

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $res = (new SystemConfig())->searchBuild($request->all())->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request){
        if ($request->isMethod('POST')) {
            $id = intval($request->get('id'));

            try {
                $this->validate($request, [
                    'key' => 'required|min:1',
                    'value' => 'required|min:1',
                ]);

                if ($id > 0) {
                    $model = SystemConfig::findOneByID($id);
                } else {
                    $model = new SystemConfig();
                }

                if ($model->fill($request->all())->save()) {
                    $this->saveEvent($model->key);
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
    public function delete(Request $request){
        if ($id = intval($request->get('id'))) {
            if ($model = SystemConfig::findOneByID($id)) {
                $this->deleteEvent($model->key);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
