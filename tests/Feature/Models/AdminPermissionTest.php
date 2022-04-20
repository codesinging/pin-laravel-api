<?php

namespace Tests\Feature\Models;

use App\Models\AdminMenu;
use App\Models\AdminPage;
use App\Models\AdminPermission;
use App\Models\AdminRoute;
use Database\Seeders\AdminMenuSeeder;
use Database\Seeders\AdminPageSeeder;
use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function testDefaultGuard()
    {
        AdminPermission::create(['name' => 'test']);

        self::assertEquals('sanctum', AdminPermission::findByName('test')['guard_name']);
    }

    public function testCreateName()
    {
        $this->seed(AdminRouteSeeder::class);
        $this->seed(AdminPageSeeder::class);
        $this->seed(AdminMenuSeeder::class);

        $adminRoute = AdminRoute::new()->first();
        $adminPage = AdminPage::new()->first();
        $adminMenu = AdminMenu::new()->first();

        self::assertEquals($adminRoute::class . ':'. $adminRoute['id'], AdminPermission::createName($adminRoute));
        self::assertEquals($adminPage::class . ':'. $adminPage['id'], AdminPermission::createName($adminPage));
        self::assertEquals($adminMenu::class . ':'. $adminMenu['id'], AdminPermission::createName($adminMenu));
    }

    public function testCreateFrom()
    {
        $this->seed(AdminRouteSeeder::class);
        $this->seed(AdminMenuSeeder::class);
        $this->seed(AdminPageSeeder::class);

        $adminRoute = AdminRoute::new()->first();
        $adminPage = AdminPage::new()->first();
        $adminMenu = AdminMenu::new()->first();

        AdminPermission::deleteFrom($adminRoute);
        AdminPermission::deleteFrom($adminPage);
        AdminPermission::deleteFrom($adminMenu);

        $adminRoutePermission = AdminPermission::createFrom($adminRoute);
        $adminPagePermission = AdminPermission::createFrom($adminPage);
        $adminMenuPermission = AdminPermission::createFrom($adminMenu);

        $adminRoute->refresh();
        $adminPage->refresh();
        $adminMenu->refresh();

        $this->assertDatabaseHas($adminRoutePermission, ['id' => $adminRoutePermission['id']]);
        $this->assertDatabaseHas($adminPagePermission, ['id' => $adminPagePermission['id']]);
        $this->assertDatabaseHas($adminMenuPermission, ['id' => $adminMenuPermission['id']]);

        self::assertEquals($adminRoute['permission_id'], $adminRoutePermission['id']);
        self::assertEquals($adminPage['permission_id'], $adminPagePermission['id']);
        self::assertEquals($adminMenu['permission_id'], $adminMenuPermission['id']);

        self::assertEquals($adminRoute['permission_id'], $adminRoute['permission']['id']);
        self::assertEquals($adminPage['permission_id'], $adminPage['permission']['id']);
        self::assertEquals($adminMenu['permission_id'], $adminMenu['permission']['id']);
    }

    public function testFindFrom()
    {
        $this->seed(AdminRouteSeeder::class);

        $adminRoute = AdminRoute::new()->first();

        $permission = AdminPermission::findFrom($adminRoute);

        self::assertEquals(AdminPermission::createName($adminRoute), $permission['name']);
    }

    public function testDeleteFrom()
    {
        $this->seed(AdminRouteSeeder::class);

        $adminRoute = AdminRoute::new()->first();

        AdminPermission::deleteFrom($adminRoute);

        $this->assertDatabaseMissing(AdminPermission::class, ['name' => AdminPermission::createName($adminRoute)]);
    }
}
