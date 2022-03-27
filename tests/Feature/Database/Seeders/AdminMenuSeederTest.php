<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\AdminMenuSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminMenuSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seed()
    {
        $this->seed(AdminMenuSeeder::class);

        $this->assertDatabaseHas('admin_menus', [
            'path' => 'home',
        ]);
    }
}
