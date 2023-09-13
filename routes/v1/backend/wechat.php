<?php

use App\Http\Controllers\Backend\Wechat\WechatMiniprogramAccountController;
use App\Http\Controllers\Backend\Wechat\WechatOfficeAccountController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'admin',
    'prefix' => 'v1/system'

], function ($router) {

    // 微信小程序会员管理
    Route::any('wechat-mini-program/index', [WechatMiniprogramAccountController::class, 'index']);
    Route::any('wechat-mini-program/view', [WechatMiniprogramAccountController::class, 'view']);
    Route::any('wechat-mini-program/delete', [WechatMiniprogramAccountController::class, 'delete']);

    // 微信公众号会员管理
    Route::any('wechat-office-account/index', [WechatOfficeAccountController::class, 'index']);
    Route::any('wechat-office-account/view', [WechatOfficeAccountController::class, 'view']);
    Route::any('wechat-office-account/delete', [WechatOfficeAccountController::class, 'delete']);
});
