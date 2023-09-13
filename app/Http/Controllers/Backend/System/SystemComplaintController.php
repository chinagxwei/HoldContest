<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\PlatformController;
use App\Models\System\SystemComplaint;
use Illuminate\Http\Request;

class SystemComplaintController extends PlatformController
{
    protected $controller_event_text = "平台系统投诉";

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $res = (new SystemComplaint())->searchBuild($request->all())->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request){
        if ($request->isMethod('POST') && $id = intval($request->get('id'))) {
            if ($model = SystemComplaint::findOneByID($id)) {
                return self::successJsonResponse($model);
            }
        }

        return self::failJsonResponse();
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
                    'title' => 'required|min:1',
                    'content' => 'required|min:1',
                ]);

                if ($id > 0) {
                    $model = SystemComplaint::findOneByID($id);
                } else {
                    $model = new SystemComplaint();
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
    public function delete(Request $request){
        if ($id = intval($request->get('id'))) {
            if ($model = SystemComplaint::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
