<?php

use App\Http\Controllers\Backend\App\AppBugLogController;
use App\Http\Controllers\Backend\App\AppPublishLogController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'admin',
    'prefix' => 'v1/system'

], function ($router) {

    // app问题管理
    Route::any('app-bug-log/index', [AppBugLogController::class, 'index']);
    Route::any('app-bug-log/save', [AppBugLogController::class, 'save']);
    Route::any('app-bug-log/view', [AppBugLogController::class, 'view']);
    Route::any('app-bug-log/delete', [AppBugLogController::class, 'delete']);

    // app发布管理
    Route::any('app-publish-log/index', [AppPublishLogController::class, 'index']);
    Route::any('app-publish-log/save', [AppPublishLogController::class, 'save']);
    Route::any('app-publish-log/view', [AppPublishLogController::class, 'view']);
    Route::any('app-publish-log/delete', [AppPublishLogController::class, 'delete']);
});
