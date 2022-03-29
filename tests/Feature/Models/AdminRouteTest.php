<?php

namespace Tests\Feature\Models;

use App\Models\AdminRoute;
use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRouteTest extends TestCase
{
    use RefreshDatabase;

    public function testPermission()
    {
        $this->seed(AdminRouteSeeder::class);

        $adminRoute = AdminRoute::new()->first();

        self::assertEquals($adminRoute['permission_id'], $adminRoute['permission']['id']);
    }
}
