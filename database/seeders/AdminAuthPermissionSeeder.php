<?php

namespace Database\Seeders;

use App\Models\AdminMenu;
use App\Models\AdminPage;
use App\Models\AdminAuthPermission;
use App\Models\AdminRoute;
use Illuminate\Database\Seeder;

class AdminAuthPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoutePermissions();
        $this->createMenuPermissions();
        $this->createPagePermissions();
    }

    /**
     * @return void
     */
    private function createRoutePermissions(): void
    {
        AdminRoute::all()->each(fn(AdminRoute $authRoute) => AdminAuthPermission::createFrom($authRoute));
    }

    /**
     * @return void
     */
    private function createMenuPermissions(): void
    {
        AdminMenu::all()->each(fn(AdminMenu $adminMenu) => AdminAuthPermission::createFrom($adminMenu));
    }

    /**
     * @return void
     */
    private function createPagePermissions(): void
    {
        AdminPage::all()->each(fn(AdminPage $adminPage) => AdminAuthPermission::createFrom($adminPage));
    }
}
