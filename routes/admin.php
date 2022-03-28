<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [Admin\AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])
    ->group(function (){

        Route::post('auth/logout', [Admin\AuthController::class, 'logout']);
        Route::get('auth/user', [Admin\AuthController::class, 'user']);

        Route::apiResource('admins', Admin\AdminController::class);

        Route::apiResource('admin_pages', Admin\AdminPageController::class);

        Route::apiResource('admin_menus', Admin\AdminMenuController::class);

        Route::apiResource('admin_roles', Admin\AdminRoleController::class);

        Route::get('auth_routes', [Admin\AdminRouteController::class, 'index']);

    });
