<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\PlatformController;
use Illuminate\Http\Request;

class  NotifyController extends PlatformController
{
    protected $controller_event_text = "回调通知";

    /**
     * 支付回调通知
     * @return void
     */
    public function payNotify(Request $request){}
}
