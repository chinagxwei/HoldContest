<?php
// 抽奖项目接口、抽奖次数接口
use App\Http\Controllers\Client\ActivityController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/client'

], function ($router) {

    Route::any('luckyDrawItem', [ActivityController::class, 'luckyDrawItem']);
});


Route::group([
    'middleware' => 'client',
    'prefix' => 'v1/client'

], function ($router) {

    Route::any('activity/luckyDrawNumber', [ActivityController::class, 'luckyDrawNumber']);
});
