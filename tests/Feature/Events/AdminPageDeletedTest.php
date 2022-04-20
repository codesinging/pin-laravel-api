<?php

namespace Tests\Feature\Events;

use App\Models\AdminPermission;
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

        $this->assertDatabaseHas(AdminPermission::class, ['name' => AdminPermission::createName($adminPage)]);

        $adminPage->delete();

        $this->assertDatabaseMissing(AdminPermission::class, ['name' => AdminPermission::createName($adminPage)]);
    }
}
