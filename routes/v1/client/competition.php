<?php
// 游戏接口、规则接口、房间接口、战队表
use App\Http\Controllers\Client\CompetitionController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/client'

], function ($router) {

    Route::any('games', [CompetitionController::class, 'games']);
    Route::any('rules', [CompetitionController::class, 'rules']);
    Route::any('rooms', [CompetitionController::class, 'rooms']);

});

Route::group([
    'middleware' => 'client',
    'prefix' => 'v1/client'

], function ($router) {
    Route::any('competition/parentGames', [CompetitionController::class, 'parentGames']);
    Route::any('competition/roomDetails', [CompetitionController::class, 'roomDetails']);
    Route::any('competition/joinRoom', [CompetitionController::class, 'joinRoom']);
    Route::any('competition/currentJoinRoom', [CompetitionController::class, 'currentJoinRoom']);
});
