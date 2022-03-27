<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\AuthRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthRouteSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seed()
    {
        $this->seed(AuthRouteSeeder::class);

        $this->assertDatabaseHas('auth_routes', ['controller' => 'Admin/Auth']);
    }
}
