<?php

namespace Tests\Feature\Events;

use App\Models\AdminPermission;
use App\Models\AdminRoute;
use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminRouteDeletedTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleted()
    {
        $this->seed(AdminRouteSeeder::class);

        $adminRoute = AdminRoute::new()->inRandomOrder()->first();

        $this->assertDatabaseHas(AdminPermission::class, ['name' => AdminPermission::createName($adminRoute)]);

        $adminRoute->delete();

        $this->assertDatabaseMissing(AdminPermission::class, ['name' => AdminPermission::createName($adminRoute)]);
    }
}
