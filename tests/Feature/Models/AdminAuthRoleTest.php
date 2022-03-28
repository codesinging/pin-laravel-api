<?php

namespace Tests\Feature\Models;

use App\Models\AdminAuthRole;
use App\Models\AdminRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthRoleTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateName()
    {
        $adminRole = AdminRole::new()->create(['name' => 'Name']);

        self::assertEquals($adminRole::class . ':' . $adminRole['id'], AdminAuthRole::createName($adminRole));
    }

    public function testCreateFrom()
    {
        $adminRole = AdminRole::new()->create(['name' => 'Name']);

        AdminAuthRole::createFrom($adminRole);

        self::assertNotNull(AdminAuthRole::findByName(AdminAuthRole::createName($adminRole)));
    }

    public function testSyncFrom()
    {
        $adminRole = AdminRole::new()->create(['name' => 'Name']);

        $role1 = AdminAuthRole::createFrom($adminRole);
        $role2 = AdminAuthRole::syncFrom($adminRole);

        self::assertNotNull(AdminAuthRole::findByName(AdminAuthRole::createName($adminRole)));
        self::assertEquals($role1['id'], $role2['id']);
        $this->assertDatabaseCount($role1, 1);
    }
}
