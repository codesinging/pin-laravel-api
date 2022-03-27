<?php

namespace Tests\Feature\Controllers\Admin;

use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AdminActing;
use Tests\TestCase;

class AdminRouteControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function test_index()
    {
        $this->seed(AdminRouteSeeder::class);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/auth_routes')
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.data.0.id',1);
    }
}
