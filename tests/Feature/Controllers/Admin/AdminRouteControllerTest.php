<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\AdminRoute;
use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AdminActing;
use Tests\TestCase;

class AdminRouteControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function testIndex()
    {
        $this->seed(AdminRouteSeeder::class);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/admin_routes')
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.0.id', 1);
    }

    public function testShow()
    {
        $this->seed(AdminRouteSeeder::class);

        $route = AdminRoute::new()->inRandomOrder()->first();

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/admin_routes/' . $route['id'])
            ->assertJsonPath('data.id', $route['id'])
            ->assertJsonPath('code', 0)
            ->assertOk();
    }
}
