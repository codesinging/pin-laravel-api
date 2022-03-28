<?php

namespace Tests\Feature\Events;

use App\Models\AdminAuthRole;
use App\Models\AdminRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminRoleDeletedTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleted()
    {
        $adminRole = AdminRole::new()->create(['name' => 'Name']);

        $this->assertDatabaseHas(AdminAuthRole::class, ['name' => AdminAuthRole::createName($adminRole)]);

        $adminRole->delete();

        $this->assertDatabaseMissing(AdminAuthRole::class, ['name' => AdminAuthRole::createName($adminRole)]);
    }
}