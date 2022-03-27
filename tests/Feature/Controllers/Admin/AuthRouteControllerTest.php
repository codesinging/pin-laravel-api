<?php

namespace Tests\Feature\Controllers\Admin;

use Database\Seeders\AuthPermissionSeeder;
use Database\Seeders\AuthRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\AdminActing;
use Tests\TestCase;

class AuthRouteControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function test_index()
    {
        $this->seed(AuthRouteSeeder::class);
        $this->seed(AuthPermissionSeeder::class);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/auth_routes')
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.data.0.id',1)
            ->assertJsonPath('data.data.0.permission.id',1);
    }
}
