<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\PlatformController;
use App\Models\Admin\AdminMessage;
use Illuminate\Http\Request;

class AdminMessageController extends PlatformController
{
    protected $controller_event_text = "管理员消息";

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $res = AdminMessage::query()->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request){
        if ($request->isMethod('POST') && $id = intval($request->get('id'))) {
            if ($model = AdminMessage::findOneByID($id)) {
                return self::successJsonResponse($model);
            }
        }

        return self::failJsonResponse();
    }

}
