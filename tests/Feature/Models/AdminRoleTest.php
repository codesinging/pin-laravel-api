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

    public function testAuthRole()
    {
        $this->seed(AdminRoleSeeder::class);

        $adminRole = AdminRole::new()->inRandomOrder()->first();

        self::assertEquals(AdminAuthRole::createName($adminRole), $adminRole->authRole()['name']);
    }
}
