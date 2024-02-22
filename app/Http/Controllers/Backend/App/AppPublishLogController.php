<?php

namespace App\Http\Controllers\Backend\App;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\App\AppPublishLog;
use Illuminate\Http\Request;

class AppPublishLogController extends PlatformController
{
    protected $controller_event_text = "app发布管理";

    public function index(Request $request){
        $res = (new AppPublishLog())->searchBuild($request->all())->paginate();
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
                    'title' => 'required|min:1',
                    'device' => 'numeric',
                    'update_method' => 'numeric',
                    'app_version' => 'required',
                    'app_version_code' => 'numeric',
                    'download_url' => 'required',
                ]);

                if ($id > 0) {
                    $model = AppPublishLog::findOneByID($id);
                } else {
                    $model = new AppPublishLog();
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
            if ($model = AppPublishLog::findOneByID($id)) {
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
            if ($model = AppPublishLog::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
