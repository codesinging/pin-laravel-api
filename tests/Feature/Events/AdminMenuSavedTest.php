<?php

namespace Tests\Feature\Events;

use App\Models\AdminAuthPermission;
use App\Models\AdminMenu;
use Database\Seeders\AdminMenuSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMenuSavedTest extends TestCase
{
    use RefreshDatabase;

    public function testSaved()
    {
        $this->seed(AdminMenuSeeder::class);

        $adminMenu = AdminMenu::new()->inRandomOrder()->first();

        $this->assertDatabaseHas(AdminAuthPermission::class, ['name' => AdminAuthPermission::createName($adminMenu)]);
    }
}
