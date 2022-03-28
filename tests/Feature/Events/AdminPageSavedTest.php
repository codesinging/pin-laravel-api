<?php

namespace Tests\Feature\Events;

use App\Models\AdminAuthPermission;
use App\Models\AdminPage;
use Database\Seeders\AdminPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPageSavedTest extends TestCase
{
    use RefreshDatabase;

    public function testSaved()
    {
        $this->seed(AdminPageSeeder::class);

        $adminPage = AdminPage::new()->inRandomOrder()->first();

        $this->assertDatabaseHas(AdminAuthPermission::class, ['name' => AdminAuthPermission::createName($adminPage)]);
    }
}
