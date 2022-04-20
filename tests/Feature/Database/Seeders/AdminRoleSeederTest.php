<?php

namespace Tests\Feature\Database\Seeders;

use App\Models\AdminRole;
use Database\Seeders\AdminRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoleSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeed()
    {
        $this->seed(AdminRoleSeeder::class);

        $this->assertDatabaseHas(AdminRole::class, ['name' => '系统管理员']);
    }
}
