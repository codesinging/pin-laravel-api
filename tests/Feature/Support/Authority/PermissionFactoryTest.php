<?php

namespace Tests\Feature\Support\Authority;

use App\Http\Controllers\Admin\AuthController;
use App\Models\AdminMenu;
use App\Support\Authority\PermissionFactory;
use Database\Seeders\AdminMenuSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionFactoryTest extends TestCase
{
    use RefreshDatabase;

    protected string $routeAction = AuthController::class . '@login';

    public function test_get_name_from_route()
    {
        self::assertEquals('route:Admin/Auth@login', PermissionFactory::getNameFromRoute($this->routeAction));
    }

    public function test_get_name_from_menu()
    {
        $this->seed(AdminMenuSeeder::class);

        $menu = AdminMenu::new()->first();

        self::assertEquals('menu:admin_menus@' . $menu['id'], PermissionFactory::getNameFromMenu($menu));
    }

    public function test_get_name_from_page()
    {
        self::assertEquals('page:admin', PermissionFactory::getNameFromPage('admin'));
    }
}
