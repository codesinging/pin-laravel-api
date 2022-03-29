<?php

namespace Tests\Feature\Models;

use App\Models\AdminAuthRole;
use App\Models\AdminRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthRoleTest extends TestCase
{
    use RefreshDatabase;

    public function testDefaultGuard()
    {
        AdminAuthRole::create(['name' => 'test']);

        self::assertEquals('sanctum', AdminAuthRole::findByName('test')['guard_name']);
    }

    public function testCreateName()
    {
        $adminRole = AdminRole::new()->create(['name' => 'Name']);

        self::assertEquals($adminRole::class . ':' . $adminRole['id'], AdminAuthRole::createName($adminRole));
    }

    public function testCreateFrom()
    {
        $adminRole = AdminRole::new()->create(['name' => 'Name']);

        AdminAuthRole::deleteFrom($adminRole);

        $adminAuthRole = AdminAuthRole::createFrom($adminRole);

        $this->assertDatabaseHas($adminAuthRole, ['id' => $adminAuthRole['id']]);
        self::assertEquals($adminRole['role_id'], $adminAuthRole['id']);
        self::assertEquals($adminRole['role_id'], $adminRole['role']['id']);
    }

    public function testFindFrom()
    {
        $adminRole = AdminRole::new()->create(['name' => 'Name']);

        $adminAuthRole = AdminAuthRole::findFrom($adminRole);

        self::assertEquals(AdminAuthRole::createName($adminRole), $adminAuthRole['name']);
    }

    public function testDeleteFrom()
    {
        $adminRole = AdminRole::new()->create(['name' => 'Name']);

        AdminAuthRole::deleteFrom($adminRole);

        $this->assertDatabaseMissing(AdminAuthRole::class, ['name' => AdminAuthRole::createName($adminRole)]);
    }
}
