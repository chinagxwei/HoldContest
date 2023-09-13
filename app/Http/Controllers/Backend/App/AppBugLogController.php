<?php

namespace App\Http\Controllers\Backend\App;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\App\AppBugLog;
use Illuminate\Http\Request;

class AppBugLogController extends PlatformController
{
    protected $controller_event_text = "app错误日志管理";

    public function index(Request $request){
        $res = (new AppBugLog())->searchBuild($request->all())->paginate();
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
                    'content' => 'required',
                    'device' => 'numeric',
                    'app_version' => 'required',
                    'app_version_code' => 'numeric',
                ]);

                if ($id > 0) {
                    $model = AppBugLog::findOneByID($id);
                } else {
                    $model = new AppBugLog();
                }

                if ($model->fill($request->all())->save()) {
                    $this->saveEvent($model->app_version);
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
            if ($model = AppBugLog::findOneByID($id)) {
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
            if ($model = AppBugLog::findOneByID($id)) {
                $this->deleteEvent($model->app_version);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
