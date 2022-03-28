<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\AdminAuthPermission;
use App\Models\AdminRole;
use Database\Seeders\AdminRoleSeeder;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AdminActing;
use Tests\TestCase;

class AdminRoleControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function testIndex()
    {
        $this->seed(AdminRoleSeeder::class);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/admin_roles')
            ->assertJsonPath('code', 0)
            ->assertOk();
    }

    public function testStore()
    {
        $this->seedAdmin()
            ->actingAsAdmin()
            ->postJson('api/admin/admin_roles', ['name' => '系统管理员'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', '系统管理员');

        $this->actingAsAdmin()
            ->postJson('api/admin/admin_roles')
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    public function testUpdate()
    {
        $data1 = ['name' => 'Name'];
        $data2 = ['name' => 'Name2'];

        $role1 = AdminRole::new()->create($data1);
        $role2 = AdminRole::new()->create($data2);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->putJson('api/admin/admin_roles/' . $role1['id'], ['name' => 'Name'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'Name');

        $this->actingAsAdmin()
            ->putJson('api/admin/admin_roles/' . $role1['id'], ['name' => 'Name2'])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    public function testShow()
    {
        $data = ['name' => 'Name', 'path' => 'path'];

        $role = AdminRole::new()->create($data);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/admin_roles/' . $role['id'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'Name');
    }

    public function testDestroy()
    {
        $data = ['name' => 'Name', 'path' => 'path'];

        $role = AdminRole::new()->create($data);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->deleteJson('api/admin/admin_roles/' . $role['id'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'Name');

        $this->assertDatabaseMissing('admin_roles', [
            'id' => $role['id'],
        ]);
    }

    /**
     * @throws Exception
     */
    public function testPermissions()
    {
        $role = AdminRole::new()->create(['name' => 'role1']);

        $permissions = [
            ['name' => 'permission1'],
            ['name' => 'permission2'],
            ['name' => 'permission3'],
            ['name' => 'permission4'],
        ];

        foreach ($permissions as $permission) {
            AdminAuthPermission::create($permission);
        }

        $role->authRole()->givePermissionTo(['permission1', 'permission3']);
        self::assertTrue($role->authRole()->hasAllPermissions(['permission1', 'permission3']));

        $this->seedAdmin();

        $this->actingAsAdmin(false)
            ->get('api/admin/admin_roles/permissions/' . $role['id'])
            ->assertJsonPath('data.0.name', 'permission1')
            ->assertJsonPath('data.1.name', 'permission3')
            ->assertJsonPath('code', 0)
            ->assertOk();
    }

    /**
     * @throws Exception
     */
    public function testGivePermissions()
    {
        $role = AdminRole::new()->create(['name' => 'role1']);

        $permissions = [
            ['name' => 'permission1'],
            ['name' => 'permission2'],
            ['name' => 'permission3'],
            ['name' => 'permission4'],
        ];

        foreach ($permissions as $permission) {
            AdminAuthPermission::create($permission);
        }

        $this->seedAdmin();

        $this->actingAsAdmin(false)
            ->postJson('api/admin/admin_roles/give_permissions/' . $role['id'], ['permissions' => 'permission1'])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $this->actingAsAdmin(false)
            ->postJson('api/admin/admin_roles/give_permissions/' . $role['id'], ['permissions' => ['permission2', 'permission3']])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $role->refresh();

        self::assertTrue($role->authRole()->hasAllPermissions('permission1', 'permission2', 'permission3'));
    }

    /**
     * @throws Exception
     */
    public function testRemovePermissions()
    {
        $role = AdminRole::new()->create(['name' => 'role1']);

        $permissions = [
            ['name' => 'permission1'],
            ['name' => 'permission2'],
            ['name' => 'permission3'],
            ['name' => 'permission4'],
        ];

        foreach ($permissions as $permission) {
            AdminAuthPermission::create($permission);
        }

        $role->authRole()->givePermissionTo(['permission1', 'permission3', 'permission4']);

        self::assertTrue($role->authRole()->hasAllPermissions(['permission1', 'permission3', 'permission4']));

        $this->seedAdmin();

        $this->actingAsAdmin(false)
            ->postJson('api/admin/admin_roles/remove_permissions/' . $role['id'], ['permissions' => 'permission1'])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $this->actingAsAdmin(false)
            ->postJson('api/admin/admin_roles/remove_permissions/' . $role['id'], ['permissions' => ['permission2', 'permission3']])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $role->refresh();

        self::assertTrue($role->authRole()->hasAllPermissions('permission4'));
        self::assertFalse($role->authRole()->hasAnyPermission('permission1', 'permission2', 'permission3'));
    }

    /**
     * @throws Exception
     */
    public function testSyncPermissions()
    {
        $role = AdminRole::new()->create(['name' => 'role1']);

        $permissions = [
            ['name' => 'permission1'],
            ['name' => 'permission2'],
            ['name' => 'permission3'],
            ['name' => 'permission4'],
        ];

        foreach ($permissions as $permission) {
            AdminAuthPermission::create($permission);
        }

        $role->authRole()->givePermissionTo(['permission1', 'permission3', 'permission4']);

        self::assertTrue($role->authRole()->hasAllPermissions(['permission1', 'permission3', 'permission4']));

        $this->seedAdmin();

        $this->actingAsAdmin(false)
            ->postJson('api/admin/admin_roles/sync_permissions/' . $role['id'], ['permissions' => 'permission1'])
            ->assertJsonPath('code', 0)
            ->assertOk();

        self::assertTrue($role->authRole()->hasAllPermissions(['permission1']));
        self::assertFalse($role->authRole()->hasAnyPermission(['permission2', 'permission3', 'permission4']));

        $this->actingAsAdmin(false)
            ->postJson('api/admin/admin_roles/sync_permissions/' . $role['id'], ['permissions' => ['permission2', 'permission3']])
            ->assertJsonPath('code', 0)
            ->assertOk();

        self::assertTrue($role->authRole()->hasAllPermissions('permission2', 'permission3'));
        self::assertFalse($role->authRole()->hasAnyPermission('permission1', 'permission4'));
    }
}
