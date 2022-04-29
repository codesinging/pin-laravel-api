<?php

namespace Tests\Feature\Database\Seeders;

use Database\Seeders\AdminPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminPageSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seed()
    {
        $this->seed(AdminPageSeeder::class);

        $this->assertDatabaseHas('admin_pages', ['path' => 'home']);
    }
}
