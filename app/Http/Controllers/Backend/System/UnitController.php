<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\PlatformController;
use App\Models\System\Unit;
use Illuminate\Http\Request;

class UnitController extends PlatformController
{
    protected $controller_event_text = "单位管理";

    public function index(Request $request)
    {
        $res = (new Unit())->searchBuild($request->all())->paginate();
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
                    'label' => 'required',
                ]);

                if ($id > 0) {
                    $model = Unit::findOneByID($id);
                } else {
                    $model = new Unit();
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
            if ($model = Unit::findOneByID($id)) {
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
            if ($model = Unit::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
