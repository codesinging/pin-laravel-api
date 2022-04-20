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

        Route::get('admins/permissions/{admin}', [Admin\AdminController::class, 'permissions']);
        Route::post('admins/give_permissions/{admin}', [Admin\AdminController::class, 'givePermissions']);
        Route::post('admins/remove_permissions/{admin}', [Admin\AdminController::class, 'removePermissions']);
        Route::post('admins/sync_permissions/{admin}', [Admin\AdminController::class, 'syncPermissions']);
        Route::get('admins/roles/{admin}', [Admin\AdminController::class, 'roles']);
        Route::post('admins/assign_roles/{admin}', [Admin\AdminController::class, 'assignRoles']);
        Route::post('admins/remove_roles/{admin}', [Admin\AdminController::class, 'removeRoles']);
        Route::post('admins/sync_roles/{admin}', [Admin\AdminController::class, 'syncRoles']);

        Route::apiResource('admins', Admin\AdminController::class);

        Route::apiResource('admin_pages', Admin\AdminPageController::class);

        Route::apiResource('admin_menus', Admin\AdminMenuController::class);

        Route::get('admin_roles/all', [Admin\AdminRoleController::class, 'all']);
        Route::get('admin_roles/permissions/{role}', [Admin\AdminRoleController::class, 'permissions']);
        Route::post('admin_roles/give_permissions/{role}', [Admin\AdminRoleController::class, 'givePermissions']);
        Route::post('admin_roles/remove_permissions/{role}', [Admin\AdminRoleController::class, 'removePermissions']);
        Route::post('admin_roles/sync_permissions/{role}', [Admin\AdminRoleController::class, 'syncPermissions']);

        Route::apiResource('admin_roles', Admin\AdminRoleController::class);

        Route::apiResource('admin_routes', Admin\AdminRouteController::class)->only('index', 'show');

    });
