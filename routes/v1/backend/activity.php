<?php

use App\Http\Controllers\Backend\LuckyDraws\LuckyDrawsConfigController;
use App\Http\Controllers\Backend\LuckyDraws\LuckyDrawsItemController;
use App\Http\Controllers\Backend\Quest\QuestController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'admin',
    'prefix' => 'v1/system'

], function ($router) {

    // 任务管理
    Route::any('quest/index', [QuestController::class, 'index']);
    Route::any('quest/save', [QuestController::class, 'save']);
    Route::any('quest/view', [QuestController::class, 'view']);
    Route::any('quest/delete', [QuestController::class, 'delete']);

    // 抽奖项管理
    Route::any('lucky-draws-item/index', [LuckyDrawsItemController::class, 'index']);
    Route::any('lucky-draws-item/save', [LuckyDrawsItemController::class, 'save']);
    Route::any('lucky-draws-item/view', [LuckyDrawsItemController::class, 'view']);
    Route::any('lucky-draws-item/delete', [LuckyDrawsItemController::class, 'delete']);

    // 抽奖配置管理
    Route::any('lucky-draws-config/index', [LuckyDrawsConfigController::class, 'index']);
    Route::any('lucky-draws-config/save', [LuckyDrawsConfigController::class, 'save']);
    Route::any('lucky-draws-config/view', [LuckyDrawsConfigController::class, 'view']);
    Route::any('lucky-draws-config/delete', [LuckyDrawsConfigController::class, 'delete']);
});
