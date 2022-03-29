<?php

namespace Tests\Feature\Models;

use App\Models\AdminPage;
use Database\Seeders\AdminPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPageTest extends TestCase
{
    use RefreshDatabase;

    public function testPermission()
    {
        $this->seed(AdminPageSeeder::class);

        $adminPage = AdminPage::new()->first();

        self::assertEquals($adminPage['permission_id'], $adminPage['permission']['id']);
    }
}
