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
}
