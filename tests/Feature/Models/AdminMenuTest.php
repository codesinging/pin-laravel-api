<?php

namespace Tests\Feature\Models;

use App\Models\AdminMenu;
use Database\Seeders\AdminMenuSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMenuTest extends TestCase
{
    use RefreshDatabase;

    public function testPermission()
    {
        $this->seed(AdminMenuSeeder::class);

        $adminMenu = AdminMenu::new()->first();

        self::assertEquals($adminMenu['permission_id'], $adminMenu['permission']['id']);
    }
}
