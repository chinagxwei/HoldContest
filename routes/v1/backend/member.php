<?php

use App\Http\Controllers\Backend\Member\MemberAddressController;
use App\Http\Controllers\Backend\Member\MemberBanController;
use App\Http\Controllers\Backend\Member\MemberController;
use App\Http\Controllers\Backend\Member\MemberGameAccountController;
use App\Http\Controllers\Backend\Member\MemberMessageController;
use App\Http\Controllers\Backend\Member\MemberPrizeLogController;
use App\Http\Controllers\Backend\Member\MemberQuestController;
use App\Http\Controllers\Backend\Member\MemberVIPController;
use App\Http\Controllers\Backend\Member\TitleController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'admin',
    'prefix' => 'v1/system'

], function ($router) {

    // 会员管理
    Route::any('member/index', [MemberController::class, 'index']);
    Route::any('member/view', [MemberController::class, 'view']);
    Route::any('member/delete', [MemberController::class, 'delete']);

    // 会员地址管理
    Route::any('member-address/index', [MemberAddressController::class, 'index']);
    Route::any('member-address/save', [MemberAddressController::class, 'save']);
    Route::any('member-address/view', [MemberAddressController::class, 'view']);
    Route::any('member-address/delete', [MemberAddressController::class, 'delete']);

    // 会员禁封管理
    Route::any('member-ban/index', [MemberBanController::class, 'index']);
    Route::any('member-ban/save', [MemberBanController::class, 'save']);
    Route::any('member-ban/view', [MemberBanController::class, 'view']);
    Route::any('member-ban/delete', [MemberBanController::class, 'delete']);

    // 会员游戏账户管理
    Route::any('member-game-account/index', [MemberGameAccountController::class, 'index']);
    Route::any('member-game-account/save', [MemberGameAccountController::class, 'save']);
    Route::any('member-game-account/view', [MemberGameAccountController::class, 'view']);
    Route::any('member-game-account/delete', [MemberGameAccountController::class, 'delete']);

    // 会员消息管理
    Route::any('member-message/index', [MemberMessageController::class, 'index']);
    Route::any('member-message/save', [MemberMessageController::class, 'save']);
    Route::any('member-message/view', [MemberMessageController::class, 'view']);
    Route::any('member-message/delete', [MemberMessageController::class, 'delete']);

    // 会员奖励记录管理
    Route::any('member-prize-log/index', [MemberPrizeLogController::class, 'index']);
    Route::any('member-prize-log/save', [MemberPrizeLogController::class, 'save']);
    Route::any('member-prize-log/view', [MemberPrizeLogController::class, 'view']);
    Route::any('member-prize-log/delete', [MemberPrizeLogController::class, 'delete']);

    // 会员任务记录管理
    Route::any('member-quest/index', [MemberQuestController::class, 'index']);
    Route::any('member-quest/save', [MemberQuestController::class, 'save']);
    Route::any('member-quest/view', [MemberQuestController::class, 'view']);
    Route::any('member-quest/delete', [MemberQuestController::class, 'delete']);

    // 会员VIP记录管理
    Route::any('member-vip/index', [MemberVIPController::class, 'index']);
    Route::any('member-vip/save', [MemberVIPController::class, 'save']);
    Route::any('member-vip/view', [MemberVIPController::class, 'view']);
    Route::any('member-vip/delete', [MemberVIPController::class, 'delete']);

    // 称号管理
    Route::any('title/index', [TitleController::class, 'index']);
    Route::any('title/save', [TitleController::class, 'save']);
    Route::any('title/view', [TitleController::class, 'view']);
    Route::any('title/delete', [TitleController::class, 'delete']);
});
