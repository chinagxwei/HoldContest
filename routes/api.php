<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/', function () {
    return 123;
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/auth'

], function ($router) {

    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    Route::any('reset-password', [\App\Http\Controllers\AuthController::class,'resetPassword']);
    Route::any('info', [\App\Http\Controllers\AuthController::class,'info']);
});

require_once "v1/index.php";
