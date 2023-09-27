<?php
// 商品接口、下单接口
use App\Http\Controllers\Client\GoodsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'client',
    'prefix' => 'v1/client'

], function ($router) {

    Route::any('goods/trade', [GoodsController::class, 'trade']);
    Route::any('goods/orders', [GoodsController::class, 'orders']);
    Route::any('goods/orderIncomes', [GoodsController::class, 'orderIncomes']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/client'

], function ($router) {

    Route::any('goodsList', [GoodsController::class, 'goodsList']);

    Route::any('goodsDetails', [GoodsController::class, 'goodsDetails']);
});


