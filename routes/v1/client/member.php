<?php
// 战绩接口、会员信息接口、vip购买接口、充值接口、协议接口、投诉接口、订单接口、会员消息接口
use App\Http\Controllers\Client\MemberAddressController;
use App\Http\Controllers\Client\MemberController;
use App\Http\Controllers\Client\MemberGameAccountController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'client',
    'prefix' => 'v1/client'

], function ($router) {

//    Route::any('member/payNotify', [MemberController::class, 'userinfo']);
    Route::any('member/competitionLogs', [MemberController::class, 'competitionLogs']);
    Route::any('member/messages', [MemberController::class, 'messages']);


    Route::any('member/addresses', [MemberAddressController::class, 'index']);
    Route::any('member/addresses/save', [MemberAddressController::class, 'save']);
    Route::any('member/addresses/delete', [MemberAddressController::class, 'delete']);
    Route::any('member/addresses/setDefault', [MemberAddressController::class, 'setDefault']);

    Route::any('member/gameAccounts', [MemberGameAccountController::class, 'index']);
    Route::any('member/gameAccounts/syncAccount', [MemberGameAccountController::class, 'syncAccount']);
});
