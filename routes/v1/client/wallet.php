<?php
//钱包接口、钱包流水接口、提款接口
use App\Http\Controllers\Client\WalletController;
use App\Http\Controllers\Client\WalletWithdrawalAccountController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'client',
    'prefix' => 'v1/client'

], function ($router) {

    Route::any('wallet/info', [WalletController::class, 'info']);
    Route::any('wallet/logs', [WalletController::class, 'logs']);
    Route::any('wallet/withdrawApply', [WalletController::class, 'withdrawApply']);
    Route::any('wallet/withdrawAmounts', [WalletController::class, 'withdrawAmounts']);

    Route::any('withdraw/Accounts', [WalletWithdrawalAccountController::class, 'index']);
    Route::any('withdraw/Accounts/save', [WalletWithdrawalAccountController::class, 'save']);
    Route::any('withdraw/Accounts/view', [WalletWithdrawalAccountController::class, 'view']);
    Route::any('withdraw/Accounts/delete', [WalletWithdrawalAccountController::class, 'delete']);
});
