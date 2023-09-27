<?php

use App\Http\Controllers\Backend\Order\OrderController;
use App\Http\Controllers\Backend\Order\OrderIncomeConfigController;
use App\Http\Controllers\Backend\Order\OrderIncomeController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'admin',
    'prefix' => 'v1/system'

], function ($router) {

    // 订单管理
    Route::any('order/index', [OrderController::class, 'index']);
//    Route::any('order/save', [OrderController::class, 'save']);
    Route::any('order/view', [OrderController::class, 'view']);
    Route::any('order/delete', [OrderController::class, 'delete']);
    Route::any('order/refund', [OrderController::class, 'refund']);

    // 订单收益管理
    Route::any('order-income/index', [OrderIncomeController::class, 'index']);
    Route::any('order-income/view', [OrderIncomeController::class, 'view']);
    Route::any('order-income/delete', [OrderIncomeController::class, 'delete']);

    // 订单收益配置管理
    Route::any('order-income-config/index', [OrderIncomeConfigController::class, 'index']);
    Route::any('order-income-config/save', [OrderIncomeConfigController::class, 'save']);
    Route::any('order-income-config/view', [OrderIncomeConfigController::class, 'view']);
    Route::any('order-income-config/delete', [OrderIncomeConfigController::class, 'delete']);
});
