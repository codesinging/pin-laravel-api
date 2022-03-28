<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\AdminRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminRoleSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeed()
    {
        $this->seed(AdminRoleSeeder::class);

        $this->assertDatabaseHas('admin_roles', ['name' => '系统管理员']);
    }
}
