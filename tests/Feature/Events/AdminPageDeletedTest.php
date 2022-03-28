<?php

namespace Tests\Feature\Events;

use App\Models\AdminAuthPermission;
use App\Models\AdminPage;
use Database\Seeders\AdminPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPageDeletedTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleted()
    {
        $this->seed(AdminPageSeeder::class);

        $adminPage = AdminPage::new()->inRandomOrder()->first();

        $this->assertDatabaseHas(AdminAuthPermission::class, ['name' => AdminAuthPermission::createName($adminPage)]);

        $adminPage->delete();

        $this->assertDatabaseMissing(AdminAuthPermission::class, ['name' => AdminAuthPermission::createName($adminPage)]);
    }
}
