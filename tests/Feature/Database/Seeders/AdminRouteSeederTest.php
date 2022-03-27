<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminRouteSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seed()
    {
        $this->seed(AdminRouteSeeder::class);

        $this->assertDatabaseHas('admin_routes', ['controller' => 'Admin/Auth']);
    }
}
