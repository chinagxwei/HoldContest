<?php

use App\Http\Controllers\Backend\Competition\CompetitionGameController;
use App\Http\Controllers\Backend\Competition\CompetitionGameTeamController;
use App\Http\Controllers\Backend\Competition\CompetitionRoomController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'admin',
    'prefix' => 'v1/system'

], function ($router) {

    // 比赛游戏管理
    Route::any('competition-game/index', [CompetitionGameController::class, 'index']);
    Route::any('competition-game/save', [CompetitionGameController::class, 'save']);
    Route::any('competition-game/view', [CompetitionGameController::class, 'view']);
    Route::any('competition-game/delete', [CompetitionGameController::class, 'delete']);

    // 游戏团队管理
    Route::any('competition-game-team/index', [CompetitionGameTeamController::class, 'index']);
    Route::any('competition-game-team/save', [CompetitionGameTeamController::class, 'save']);
    Route::any('competition-game-team/view', [CompetitionGameTeamController::class, 'view']);
    Route::any('competition-game-team/delete', [CompetitionGameTeamController::class, 'delete']);

    // 游戏房间管理
    Route::any('competition-room/index', [CompetitionRoomController::class, 'index']);
    Route::any('competition-room/save', [CompetitionRoomController::class, 'save']);
    Route::any('competition-room/view', [CompetitionRoomController::class, 'view']);
    Route::any('competition-room/delete', [CompetitionRoomController::class, 'delete']);

});
