<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\PlatformController;
use App\Models\System\SystemImage;
use Illuminate\Http\Request;

class SystemImageController extends PlatformController
{
    protected $controller_event_text = "平台系统图片";

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $res = (new SystemImage())->searchBuild($request->all())->paginate();
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
                    'description' => 'min:0',
                    'url' => 'required|min:1',
                ]);

                if ($id > 0) {
                    $model = SystemImage::findOneByID($id);
                } else {
                    $model = new SystemImage();
                }

                if ($model->fill($request->all())->save()) {
                    $this->saveEvent($model->id);
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
    public function delete(Request $request)
    {
        if ($id = $request->input('id')) {
            if ($model = SystemImage::findOneByID($id)) {
                $this->deleteEvent($model->id);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
