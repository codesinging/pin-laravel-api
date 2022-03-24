<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seed_admin()
    {
        $this->seed(AdminSeeder::class);

        $this->assertDatabaseHas('admins', ['super' => false]);
        $this->assertDatabaseHas('admins', ['super' => true]);

        $this->assertDatabaseCount('admins', 2);
    }
}
