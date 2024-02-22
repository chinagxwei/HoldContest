<?php

use App\Http\Controllers\Client\NotifyController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/client'

], function ($router) {

//    Route::any('notify/payNotify', [NotifyController::class, 'payNotify']);
});
