<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [Admin\AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'permission'])
    ->group(function () {

        Route::post('auth/logout', [Admin\AuthController::class, 'logout']);
        Route::get('auth/user', [Admin\AuthController::class, 'user']);
        Route::get('auth/pages', [Admin\AuthController::class, 'pages']);
        Route::get('auth/menus', [Admin\AuthController::class, 'menus']);

        Route::get('admins/{admin}/permissions', [Admin\AdminController::class, 'permissions']);
        Route::post('admins/{admin}/give_permissions', [Admin\AdminController::class, 'givePermissions']);
        Route::post('admins/{admin}/remove_permissions', [Admin\AdminController::class, 'removePermissions']);
        Route::post('admins/{admin}/sync_permissions', [Admin\AdminController::class, 'syncPermissions']);
        Route::get('admins/{admin}/roles', [Admin\AdminController::class, 'roles']);
        Route::post('admins/{admin}/assign_roles', [Admin\AdminController::class, 'assignRoles']);
        Route::post('admins/{admin}/remove_roles', [Admin\AdminController::class, 'removeRoles']);
        Route::post('admins/{admin}/sync_roles', [Admin\AdminController::class, 'syncRoles']);

        Route::apiResource('admins', Admin\AdminController::class);

        Route::apiResource('admin_pages', Admin\AdminPageController::class);

        Route::apiResource('admin_menus', Admin\AdminMenuController::class);

        Route::get('admin_roles/all', [Admin\AdminRoleController::class, 'all']);
        Route::get('admin_roles/{role}/permissions', [Admin\AdminRoleController::class, 'permissions']);
        Route::post('admin_roles/{role}/give_permissions', [Admin\AdminRoleController::class, 'givePermissions']);
        Route::post('admin_roles/{role}/remove_permissions', [Admin\AdminRoleController::class, 'removePermissions']);
        Route::post('admin_roles/{role}/sync_permissions', [Admin\AdminRoleController::class, 'syncPermissions']);

        Route::apiResource('admin_roles', Admin\AdminRoleController::class);

        Route::apiResource('admin_routes', Admin\AdminRouteController::class)->only('index', 'show');

    });
