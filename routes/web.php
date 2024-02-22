<?php

use App\Http\Controllers\TestController;
use App\Http\MyCustomWebSocketHandler;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', function () {
    return view('welcome');
});

Route::any('/test', [TestController::class, 'test']);

Route::prefix('/admin')->group(function () {
    Route::any('/{action?}', function () {
        return view('admin');
    });
});

Route::prefix('/admin/platform')->group(function () {
    Route::any('/{action?}', function () {
        return view('admin');
    });
});

Route::prefix('/admin/platform/system')->group(function () {
    Route::any('/{action?}', function () {
        return view('admin');
    });
});

\BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter::webSocket('/v1/im-server', MyCustomWebSocketHandler::class);
