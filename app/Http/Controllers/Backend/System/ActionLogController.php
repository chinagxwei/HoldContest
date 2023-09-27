<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use Illuminate\Http\Request;

class ActionLogController extends PlatformController
{
    protected $controller_event_text = "管理员日志";

    public function index(Request $request){
        $res = (new ActionLog())->searchBuild($request->all())->paginate();
        return self::successJsonResponse($res);
    }
}
