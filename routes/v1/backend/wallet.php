<?php

use App\Http\Controllers\Backend\Wallet\WalletConsumeController;
use App\Http\Controllers\Backend\Wallet\WalletController;
use App\Http\Controllers\Backend\Wallet\WalletLogController;
use App\Http\Controllers\Backend\Wallet\WalletRechargeController;
use App\Http\Controllers\Backend\Wallet\WalletWithdrawalAccountController;
use App\Http\Controllers\Backend\Wallet\WalletWithdrawalController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'admin',
    'prefix' => 'v1/system'

], function ($router) {

    // 钱包管理
    Route::any('wallet/index', [WalletController::class, 'index']);
    Route::any('wallet/save', [WalletController::class, 'save']);
    Route::any('wallet/view', [WalletController::class, 'view']);
    Route::any('wallet/delete', [WalletController::class, 'delete']);

    // 钱包充值管理
    Route::any('wallet-recharge/index', [WalletRechargeController::class, 'index']);
    Route::any('wallet-recharge/save', [WalletRechargeController::class, 'save']);
    Route::any('wallet-recharge/view', [WalletRechargeController::class, 'view']);
    Route::any('wallet-recharge/delete', [WalletRechargeController::class, 'delete']);

    // 钱包提现管理
    Route::any('wallet-withdrawal/index', [WalletWithdrawalController::class, 'index']);
    Route::any('wallet-withdrawal/save', [WalletWithdrawalController::class, 'save']);
    Route::any('wallet-withdrawal/view', [WalletWithdrawalController::class, 'view']);
    Route::any('wallet-withdrawal/delete', [WalletWithdrawalController::class, 'delete']);

    // 钱包提现账户管理
    Route::any('wallet-withdrawal-account/index', [WalletWithdrawalAccountController::class, 'index']);
    Route::any('wallet-withdrawal-account/save', [WalletWithdrawalAccountController::class, 'save']);
    Route::any('wallet-withdrawal-account/view', [WalletWithdrawalAccountController::class, 'view']);
    Route::any('wallet-withdrawal-account/delete', [WalletWithdrawalAccountController::class, 'delete']);

    // 钱包消费管理
    Route::any('wallet-consume/index', [WalletConsumeController::class, 'index']);
    Route::any('wallet-consume/save', [WalletConsumeController::class, 'save']);
    Route::any('wallet-consume/view', [WalletConsumeController::class, 'view']);
    Route::any('wallet-consume/delete', [WalletConsumeController::class, 'delete']);

    // 钱包日志管理
    Route::any('wallet-log/index', [WalletLogController::class, 'index']);
    Route::any('wallet-log/save', [WalletLogController::class, 'save']);
    Route::any('wallet-log/view', [WalletLogController::class, 'view']);
    Route::any('wallet-log/delete', [WalletLogController::class, 'delete']);
});
