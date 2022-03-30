<?php

namespace Tests\Feature\Support\Model;

use App\Models\AdminMenu;
use App\Models\AdminPage;
use App\Models\AdminRoute;
use Database\Seeders\AdminMenuSeeder;
use Database\Seeders\AdminPageSeeder;
use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AdminActing;
use Tests\TestCase;

class PermissionTraitsTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function testGetPermissionsFrom()
    {
        $this->seedAdmin();

        $this->seed(AdminPageSeeder::class);
        $this->seed(AdminRouteSeeder::class);
        $this->seed(AdminMenuSeeder::class);

        $adminPagePermissions = AdminPage::all()->random(2)->pluck('permission_id');
        $adminRoutePermissions = AdminRoute::all()->random(3)->pluck('permission_id');
        $adminMenuPermissions = AdminMenu::all()->random(1)->pluck('permission_id');

        $admin = $this->getAdmin();

        $admin->givePermissionTo($adminPagePermissions);
        $admin->givePermissionTo($adminRoutePermissions);
        $admin->givePermissionTo($adminMenuPermissions);

        $pagePermissions = $admin->getPermissionsFrom(AdminPage::class);
        $routePermissions = $admin->getPermissionsFrom(AdminRoute::class);
        $menuPermissions = $admin->getPermissionsFrom(AdminMenu::class);

        self::assertEquals($adminPagePermissions->count(), $pagePermissions->count());
        self::assertEquals($adminPagePermissions, $pagePermissions->pluck('id'));

        self::assertEquals($adminRoutePermissions->count(), $routePermissions->count());
        self::assertEquals($adminRoutePermissions, $routePermissions->pluck('id'));

        self::assertEquals($adminMenuPermissions->count(), $menuPermissions->count());
        self::assertEquals($adminMenuPermissions, $menuPermissions->pluck('id'));
    }

    public function testGetPermittedModels()
    {
        $this->seedAdmin();

        $this->seed(AdminPageSeeder::class);
        $this->seed(AdminRouteSeeder::class);
        $this->seed(AdminMenuSeeder::class);

        $adminPages= AdminPage::all()->random(2);
        $adminRoutes = AdminRoute::all()->random(3);
        $adminMenus = AdminMenu::all()->random(1);

        $admin = $this->getAdmin();

        $admin->givePermissionTo($adminPages->pluck('permission_id'));
        $admin->givePermissionTo($adminRoutes->pluck('permission_id'));
        $admin->givePermissionTo($adminMenus->pluck('permission_id'));

        self::assertEquals($adminPages->pluck('id'), $admin->getPermittedModels(AdminPage::class)->pluck('id'));
        self::assertEquals($adminRoutes->pluck('id'), $admin->getPermittedModels(AdminRoute::class)->pluck('id'));
        self::assertEquals($adminMenus->pluck('id'), $admin->getPermittedModels(AdminMenu::class)->pluck('id'));
    }
}
