<?php

namespace Tests\Feature\Database\Seeders;

use App\Models\AdminMenu;
use App\Models\AdminPage;
use App\Models\AdminAuthPermission;
use App\Models\AdminRoute;
use Database\Seeders\AdminMenuSeeder;
use Database\Seeders\AdminPageSeeder;
use Database\Seeders\AdminAuthPermissionSeeder;
use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthPermissionSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seed()
    {
        $this->seed(AdminRouteSeeder::class);
        $this->seed(AdminPageSeeder::class);
        $this->seed(AdminMenuSeeder::class);
        $this->seed(AdminAuthPermissionSeeder::class);

        $adminRoute = AdminRoute::new()->inRandomOrder()->first();
        $adminPage = AdminPage::new()->inRandomOrder()->first();
        $adminMenu = AdminMenu::new()->inRandomOrder()->first();

        self::assertNotNull(AdminAuthPermission::findByName(AdminAuthPermission::createName($adminRoute)));
        self::assertNotNull(AdminAuthPermission::findByName(AdminAuthPermission::createName($adminPage)));
        self::assertNotNull(AdminAuthPermission::findByName(AdminAuthPermission::createName($adminMenu)));
    }
}
