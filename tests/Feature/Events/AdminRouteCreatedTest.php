<?php

namespace Tests\Feature\Events;

use App\Models\AdminAuthPermission;
use App\Models\AdminRoute;
use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRouteCreatedTest extends TestCase
{
    use RefreshDatabase;

    public function testSaved()
    {
        $this->seed(AdminRouteSeeder::class);

        $adminRoute = AdminRoute::new()->inRandomOrder()->first();

        $this->assertDatabaseHas(AdminAuthPermission::class, ['name' => AdminAuthPermission::createName($adminRoute)]);
    }
}
