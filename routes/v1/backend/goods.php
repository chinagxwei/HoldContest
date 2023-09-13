<?php

use App\Http\Controllers\Backend\Goods\GoodsController;
use App\Http\Controllers\Backend\Product\ProductRechargeController;
use App\Http\Controllers\Backend\Product\ProductVIPController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'admin',
    'prefix' => 'v1/system'

], function ($router) {

    // 商品管理
    Route::any('goods/index', [GoodsController::class, 'index']);
    Route::any('goods/save', [GoodsController::class, 'save']);
    Route::any('goods/view', [GoodsController::class, 'view']);
    Route::any('goods/delete', [GoodsController::class, 'delete']);

    // 充值产品
    Route::any('product-recharge/index', [ProductRechargeController::class, 'index']);
    Route::any('product-recharge/save', [ProductRechargeController::class, 'save']);
    Route::any('product-recharge/view', [ProductRechargeController::class, 'view']);
    Route::any('product-recharge/delete', [ProductRechargeController::class, 'delete']);

    // VIP产品
    Route::any('product-vip/index', [ProductVIPController::class, 'index']);
    Route::any('product-vip/save', [ProductVIPController::class, 'save']);
    Route::any('product-vip/view', [ProductVIPController::class, 'view']);
    Route::any('product-vip/delete', [ProductVIPController::class, 'delete']);
});
