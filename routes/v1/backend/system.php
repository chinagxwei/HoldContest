<?php

use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Admin\AdminNavigationController;
use App\Http\Controllers\Backend\Admin\AdminRoleController;
use App\Http\Controllers\Backend\System\ActionLogController;
use App\Http\Controllers\Backend\System\SystemAgreementController;
use App\Http\Controllers\Backend\System\SystemComplaintController;
use App\Http\Controllers\Backend\System\SystemConfigController;
use App\Http\Controllers\Backend\System\SystemImageController;
use App\Http\Controllers\Backend\System\TargetController;
use App\Http\Controllers\Backend\System\UnitController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'admin',
    'prefix' => 'v1/system'

], function ($router) {
    // 日志
    Route::any('log/index', [ActionLogController::class, 'index']);

    // 管理员
    Route::any('manager/index', [AdminController::class, 'index']);
    Route::any('manager/save', [AdminController::class, 'save']);
    Route::any('manager/delete', [AdminController::class, 'delete']);

    // 导航菜单
    Route::any('navigation/index', [AdminNavigationController::class, 'index']);
    Route::any('navigation/save', [AdminNavigationController::class, 'save']);
    Route::any('navigation/delete', [AdminNavigationController::class, 'delete']);
    Route::any('navigation/all', [AdminNavigationController::class, 'allMenu']);
    Route::any('navigation/sort-change', [AdminNavigationController::class, 'sortChange']);

    // 管理员角色
    Route::any('role/index', [AdminRoleController::class, 'index']);
    Route::any('role/save', [AdminRoleController::class, 'save']);
    Route::any('role/view', [AdminRoleController::class, 'view']);
    Route::any('role/delete', [AdminRoleController::class, 'delete']);
    Route::any('role/config-menu', [AdminRoleController::class, 'configMenu']);
    Route::any('role/search', [AdminRoleController::class, 'search']);

    // 平台协议
    Route::any('agreement/index', [SystemAgreementController::class, 'index']);
    Route::any('agreement/save', [SystemAgreementController::class, 'save']);
    Route::any('agreement/view', [SystemAgreementController::class, 'view']);
    Route::any('agreement/delete', [SystemAgreementController::class, 'delete']);

    // 平台投诉
    Route::any('complaint/index', [SystemComplaintController::class, 'index']);
    Route::any('complaint/save', [SystemComplaintController::class, 'save']);
    Route::any('complaint/view', [SystemComplaintController::class, 'view']);
    Route::any('complaint/delete', [SystemComplaintController::class, 'delete']);

    // 平台配置
    Route::any('config/index', [SystemConfigController::class, 'index']);
    Route::any('config/save', [SystemConfigController::class, 'save']);
    Route::any('config/delete', [SystemConfigController::class, 'delete']);

    // 平台图片
    Route::any('image/index', [SystemImageController::class, 'index']);
    Route::any('image/save', [SystemImageController::class, 'save']);
    Route::any('image/view', [SystemImageController::class, 'view']);
    Route::any('image/delete', [SystemImageController::class, 'delete']);

    // 平台标签
    Route::any('target/index', [TargetController::class, 'index']);
    Route::any('target/save', [TargetController::class, 'save']);
    Route::any('target/view', [TargetController::class, 'view']);
    Route::any('target/delete', [TargetController::class, 'delete']);

    // 平台单位
    Route::any('unit/index', [UnitController::class, 'index']);
    Route::any('unit/save', [UnitController::class, 'save']);
    Route::any('unit/view', [UnitController::class, 'view']);
    Route::any('unit/delete', [UnitController::class, 'delete']);
});
