<?php

namespace Tests\Feature\Models;

use App\Models\AdminAuthRole;
use App\Models\AdminRole;
use Database\Seeders\AdminRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoleTest extends TestCase
{
    use RefreshDatabase;

    public function testRole()
    {
        $this->seed(AdminRoleSeeder::class);

        $adminRole = AdminRole::new()->first();

        self::assertEquals($adminRole['role_id'], $adminRole['role']['id']);
    }

    public function testAuthRole()
    {
        $this->seed(AdminRoleSeeder::class);

        $adminRole = AdminRole::new()->inRandomOrder()->first();

        self::assertEquals(AdminAuthRole::createName($adminRole), $adminRole->role['name']);
    }
}
