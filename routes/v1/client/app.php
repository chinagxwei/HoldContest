<?php
// 版本接口、应用更新接口
use App\Http\Controllers\Client\AgreementController;
use App\Http\Controllers\Client\AppController;
use App\Http\Controllers\Client\BannerController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/client'

], function ($router) {

    Route::any('latestVersion', [AppController::class, 'latestVersion']);

    Route::any('memberServiceTerms', [AgreementController::class, 'memberServiceTerms']);

    Route::any('memberPrivacyAgreement', [AgreementController::class, 'memberPrivacyAgreement']);

    Route::any('memberRechargeAgreement', [AgreementController::class, 'memberRechargeAgreement']);

    Route::any('memberShipAgreement', [AgreementController::class, 'memberShipAgreement']);

    Route::any('agreements', [AppController::class, 'agreements']);

    Route::any('banner-for-home', [BannerController::class, 'home']);

    Route::any('banner-for-roomList', [BannerController::class, 'roomList']);

    Route::any('banner-for-roomDetail', [BannerController::class, 'roomDetail']);

    Route::any('banner-for-userinfo', [BannerController::class, 'userinfo']);

    Route::any('banner-for-square', [BannerController::class, 'square']);

    Route::any('withdrawConfigs', [AppController::class, 'withdrawConfigs']);

    Route::any('vipConfigs', [AppController::class, 'vipConfigs']);

    Route::any('rechargeConfigs', [AppController::class, 'rechargeConfigs']);

    Route::any('sendSms', [AppController::class, 'sendSms']);
});
