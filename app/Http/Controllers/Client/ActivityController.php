<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\PlatformController;
use Illuminate\Http\Request;

class ActivityController extends PlatformController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['luckyDrawItem']]);
    }

    /**
     * 抽奖项目列表
     * @return void
     */
    public function luckyDrawItem(Request $request)
    {

    }

    /**
     * 抽奖次数
     * @return void
     */
    public function luckyDrawNumber(Request $request)
    {

    }
}
