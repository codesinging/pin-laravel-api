<?php

namespace Tests\Feature\Models;

use App\Models\AdminMenu;
use App\Models\AdminPage;
use App\Models\AdminAuthPermission;
use App\Models\AdminRoute;
use Database\Seeders\AdminMenuSeeder;
use Database\Seeders\AdminPageSeeder;
use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function testDefaultGuard()
    {
        AdminAuthPermission::create(['name' => 'test']);

        self::assertEquals('sanctum', AdminAuthPermission::findByName('test')['guard_name']);
    }

    public function testCreateName()
    {
        $this->seed(AdminRouteSeeder::class);
        $this->seed(AdminPageSeeder::class);
        $this->seed(AdminMenuSeeder::class);

        $adminRoute = AdminRoute::new()->first();
        $adminPage = AdminPage::new()->first();
        $adminMenu = AdminMenu::new()->first();

        self::assertEquals($adminRoute::class . ':'. $adminRoute['id'], AdminAuthPermission::createName($adminRoute));
        self::assertEquals($adminPage::class . ':'. $adminPage['id'], AdminAuthPermission::createName($adminPage));
        self::assertEquals($adminMenu::class . ':'. $adminMenu['id'], AdminAuthPermission::createName($adminMenu));
    }

    public function testCreateFrom()
    {
        $this->seed(AdminRouteSeeder::class);
        $this->seed(AdminMenuSeeder::class);
        $this->seed(AdminPageSeeder::class);

        $adminRoute = AdminRoute::new()->first();
        $adminPage = AdminPage::new()->first();
        $adminMenu = AdminMenu::new()->first();

        AdminAuthPermission::deleteFrom($adminRoute);
        AdminAuthPermission::deleteFrom($adminPage);
        AdminAuthPermission::deleteFrom($adminMenu);

        $adminRoutePermission = AdminAuthPermission::createFrom($adminRoute);
        $adminPagePermission = AdminAuthPermission::createFrom($adminPage);
        $adminMenuPermission = AdminAuthPermission::createFrom($adminMenu);

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

        $permission = AdminAuthPermission::findFrom($adminRoute);

        self::assertEquals(AdminAuthPermission::createName($adminRoute), $permission['name']);
    }

    public function testDeleteFrom()
    {
        $this->seed(AdminRouteSeeder::class);

        $adminRoute = AdminRoute::new()->first();

        AdminAuthPermission::deleteFrom($adminRoute);

        $this->assertDatabaseMissing(AdminAuthPermission::class, ['name' => AdminAuthPermission::createName($adminRoute)]);
    }
}
