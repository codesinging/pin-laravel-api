<?php

namespace Tests\Feature\Controllers\Admin;

use App\Exceptions\ErrorCode;
use App\Models\AdminAuthPermission;
use App\Models\AdminAuthRole;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\AdminActing;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function testIndex()
    {
        $this->seedAdmin();

        $this->actingAsAdmin()
            ->getJson('api/admin/admins')
            ->assertJsonPath('data.data.0.id', 1)
            ->assertJsonPath('code', 0)
            ->assertOk();
    }

    public function testStoreValidation()
    {
        $this->seedAdmin();

        $this->actingAsAdmin()
            ->postJson('api/admin/admins', ['username' => 'admin1'])
            ->assertJsonStructure(['message', 'errors' => ['name']])
            ->assertStatus(422);

        $this->actingAsAdmin()
            ->postJson('api/admin/admins', ['username' => 'admin1', 'name' => 'Admin1'])
            ->assertJsonStructure(['message', 'errors' => ['password']])
            ->assertStatus(422);

        $this->actingAsAdmin()
            ->postJson('api/admin/admins', ['username' => 'admin', 'name' => 'Admin', 'password' => 'admin.123'])
            ->assertJsonStructure(['message', 'errors' => ['username', 'name']])
            ->assertStatus(422);
    }

    public function testStore()
    {
        $this->seedAdmin();

        $this->actingAsAdmin()
            ->postJson('api/admin/admins', ['username' => 'admin1', 'name' => 'Admin1', 'password' => 'admin.123'])
            ->assertJsonPath('data.username', 'admin1')
            ->assertOk();
    }

    public function testUpdateValidation()
    {
        $this->seedAdmin();

        $admin1 = $this->getAdmin(['id' => 1]);
        $admin2 = $this->getAdmin(['id' => 2]);

        $this->actingAsAdmin()
            ->putJson('api/admin/admins/' . $admin1['id'], ['username' => 'new username'])
            ->assertJsonStructure(['message', 'errors' => ['name']])
            ->assertStatus(422);

        $this->actingAsAdmin()
            ->putJson('api/admin/admins/' . $admin1['id'], ['username' => $admin2['username'], 'name' => $admin2['name']])
            ->assertJsonStructure(['message', 'errors' => ['name', 'username']])
            ->assertStatus(422);
    }

    public function testUpdate()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin(false);
        $superAdmin = $this->getAdmin(true);

        // 修改账号和名称
        $this->actingAsAdmin($admin)
            ->putJson('api/admin/admins/' . $admin['id'], ['username' => 'new username', 'name' => 'new name'])
            ->assertJsonPath('data.username', 'new username')
            ->assertJsonPath('data.name', 'new name')
            ->assertOk();

        // 修改密码
        $this->actingAsAdmin($admin)
            ->putJson('api/admin/admins/' . $admin['id'], ['username' => 'new username', 'name' => 'new name', 'password' => 'admin.222'])
            ->assertJsonPath('data.username', 'new username')
            ->assertJsonPath('data.name', 'new name')
            ->assertOk();

        $admin->refresh();

        self::assertEquals('new username', $admin['username']);
        self::assertEquals('new name', $admin['name']);

        self::assertTrue(Hash::check('admin.222', $admin['password']));
    }

    public function testCommonAdminCanNotUpdateSuperAdmin()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin(false);
        $superAdmin = $this->getAdmin(true);

        $originSuperAdmin = $superAdmin->toArray();

        $this->actingAsAdmin($admin)
            ->putJson('api/admin/admins/' . $superAdmin['id'], ['username' => 'new username', 'name' => 'new name', 'password' => 'new password'])
            ->assertJsonPath('code', ErrorCode::SUPER_ADMIN_UPDATE_ERROR->value)
            ->assertOk();

        $superAdmin->refresh();
        self::assertEquals($originSuperAdmin['username'], $superAdmin['username']);
        self::assertTrue(Hash::check('admin.123', $superAdmin['password']));
    }

    public function testSuperAdminCanUpdateCommonAdmin()
    {
        $this->seedAdmin();

        $superAdmin = $this->getAdmin(true);

        $this->actingAsAdmin($superAdmin)
            ->putJson('api/admin/admins/' . $superAdmin['id'], ['username' => 'new username', 'name' => 'new name', 'password' => 'new password'])
            ->assertJsonPath('code', ErrorCode::OK->value)
            ->assertOk();

        $superAdmin->refresh();
        self::assertEquals('new username', $superAdmin['username']);
        self::assertEquals('new name', $superAdmin['name']);
        self::assertTrue(Hash::check('new password', $superAdmin['password']));
    }

    public function testShow()
    {
        $this->seedAdmin();
        $admin = $this->getAdmin();

        $this->actingAsAdmin($admin)
            ->getJson('api/admin/admins/' . $admin['id'])
            ->assertJsonPath('data.id', $admin['id'])
            ->assertOk();
    }

    public function testShowNotExist()
    {
        $this->seedAdmin();

        $this->actingAsAdmin()
            ->getJson('api/admin/admins/33343')
            ->assertNotFound();
    }

    public function testDestroyCommonAdmin()
    {
        $this->seedAdmin();

        $commonAdmin = $this->getAdmin(false);
        $superAdmin = $this->getAdmin(true);

        $this->actingAsAdmin($superAdmin)
            ->deleteJson('api/admin/admins/' . $commonAdmin['id'])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $this->assertDatabaseMissing('admins', ['id' => $commonAdmin['id']]);
    }

    public function testDestroySuperAdmin()
    {
        $this->seedAdmin();

        $superAdmin = $this->getAdmin(true);

        $this->actingAsAdmin($superAdmin)
            ->deleteJson('api/admin/admins/' . $superAdmin['id'])
            ->assertJsonPath('code', ErrorCode::SUPER_ADMIN_DELETE_ERROR->value)
            ->assertOk();

        $this->assertDatabaseHas('admins', ['id' => $superAdmin['id']]);
    }

    public function testPermissions()
    {
        $permissions = [
            ['name' => 'test1'],
            ['name' => 'test2'],
            ['name' => 'test3'],
            ['name' => 'test4'],
        ];

        foreach ($permissions as $permission) {
            AdminAuthPermission::create($permission);
        }

        $admin = $this->seedAdmin()->getAdmin(false);

        $admin->givePermissionTo(['test1', 'test2']);

        $this->actingAsAdmin($admin)
            ->getJson('api/admin/admins/permissions/' . $admin['id'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.0.name', 'test1')
            ->assertJsonPath('data.1.name', 'test2');
    }

    /**
     * @throws Exception
     */
    public function testGivePermissions()
    {
        $permissions = [
            ['name' => 'test1'],
            ['name' => 'test2'],
            ['name' => 'test3'],
            ['name' => 'test4'],
        ];

        foreach ($permissions as $permission) {
            AdminAuthPermission::create($permission);
        }

        $admin = $this->seedAdmin()->getAdmin(false);

        $this->actingAsAdmin($admin)
            ->postJson('api/admin/admins/give_permissions/' . $admin['id'], ['permissions' => 'test1'])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $this->actingAsAdmin($admin)
            ->postJson('api/admin/admins/give_permissions/' . $admin['id'], ['permissions' => ['test2', 'test3']])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $admin->refresh();

        self::assertTrue($admin->hasAllPermissions(['test1', 'test2', 'test3']));
        self::assertFalse($admin->hasPermissionTo('test4'));
    }

    /**
     * @throws Exception
     */
    public function testRemovePermissions()
    {
        $permissions = [
            ['name' => 'test1'],
            ['name' => 'test2'],
            ['name' => 'test3'],
            ['name' => 'test4'],
        ];

        foreach ($permissions as $permission) {
            AdminAuthPermission::create($permission);
        }

        $admin = $this->seedAdmin()->getAdmin(false);

        $admin->givePermissionTo(['test1', 'test2', 'test3']);

        self::assertTrue($admin->hasAllPermissions(['test1', 'test2', 'test3']));
        self::assertFalse($admin->hasPermissionTo('test4'));

        $this->actingAsAdmin($admin)
            ->postJson('api/admin/admins/remove_permissions/' . $admin['id'], ['permissions' => 'test1'])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $this->actingAsAdmin($admin)
            ->postJson('api/admin/admins/remove_permissions/' . $admin['id'], ['permissions' => ['test2', 'test3']])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $admin->refresh();

        self::assertFalse($admin->hasAnyPermission(['test1', 'test2', 'test3', 'test4']));
    }

    /**
     * @throws Exception
     */
    public function testSyncPermissions()
    {
        $permissions = [
            ['name' => 'test1'],
            ['name' => 'test2'],
            ['name' => 'test3'],
            ['name' => 'test4'],
        ];

        foreach ($permissions as $permission) {
            AdminAuthPermission::create($permission);
        }

        $admin = $this->seedAdmin()->getAdmin(false);

        $admin->givePermissionTo(['test1', 'test3']);

        self::assertTrue($admin->hasAllPermissions(['test1', 'test3']));
        self::assertFalse($admin->hasAnyPermission(['test2', 'test4']));

        $this->actingAsAdmin($admin)
            ->postJson('api/admin/admins/sync_permissions/' . $admin['id'], ['permissions' => ['test2', 'test3']])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $admin->refresh();

        self::assertTrue($admin->hasAllPermissions(['test2', 'test3']));
        self::assertFalse($admin->hasAnyPermission(['test1', 'test4']));
    }

    public function testRoles()
    {
        $roles = [
            ['name' => 'test1'],
            ['name' => 'test2'],
            ['name' => 'test3'],
            ['name' => 'test4'],
        ];

        foreach ($roles as $role) {
            AdminAuthRole::create($role);
        }

        $admin = $this->seedAdmin()->getAdmin(false);

        $admin->assignRole(['test3', 'test4']);

        $this->actingAsAdmin($admin)
            ->getJson('api/admin/admins/roles/' . $admin['id'])
            ->assertJsonPath('data.0.name', 'test3')
            ->assertJsonPath('data.1.name', 'test4')
            ->assertJsonPath('code', 0)
            ->assertOk();
    }

    public function testAssignRoles()
    {
        $roles = [
            ['name' => 'test1'],
            ['name' => 'test2'],
            ['name' => 'test3'],
            ['name' => 'test4'],
        ];

        foreach ($roles as $role) {
            AdminAuthRole::create($role);
        }

        $admin = $this->seedAdmin()->getAdmin(false);

        self::assertFalse($admin->hasAnyRole(['test1', 'test2', 'test3', 'test4']));

        $this->actingAsAdmin($admin)
            ->postJson('api/admin/admins/assign_roles/' . $admin['id'], ['roles' => 'test1'])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $this->actingAsAdmin($admin)
            ->postJson('api/admin/admins/assign_roles/' . $admin['id'], ['roles' => ['test2', 'test3']])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $admin->refresh();

        self::assertTrue($admin->hasAllRoles(['test1', 'test2', 'test3']));
    }

    public function testRemoveRoles()
    {
        $roles = [
            ['name' => 'test1'],
            ['name' => 'test2'],
            ['name' => 'test3'],
            ['name' => 'test4'],
        ];

        foreach ($roles as $role) {
            AdminAuthRole::create($role);
        }

        $admin = $this->seedAdmin()->getAdmin(false);

        $admin->assignRole(['test1', 'test3', 'test4']);

        self::assertTrue($admin->hasAllRoles(['test1', 'test3', 'test4']));

        $this->actingAsAdmin($admin)
            ->postJson('api/admin/admins/remove_roles/' . $admin['id'], ['roles' => 'test1'])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $this->actingAsAdmin($admin)
            ->postJson('api/admin/admins/remove_roles/' . $admin['id'], ['roles' => ['test3', 'test4']])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $admin->refresh();

        self::assertFalse($admin->hasAnyRole(['test1', 'test2', 'test3', 'test4']));
    }

    public function testSyncRoles()
    {
        $roles = [
            ['name' => 'test1'],
            ['name' => 'test2'],
            ['name' => 'test3'],
            ['name' => 'test4'],
        ];

        foreach ($roles as $role) {
            AdminAuthRole::create($role);
        }

        $admin = $this->seedAdmin()->getAdmin(false);

        self::assertFalse($admin->hasAnyRole(['test1', 'test2', 'test3', 'test4']));

        $this->actingAsAdmin()
            ->postJson('api/admin/admins/sync_roles/' . $admin['id'], ['roles' => 'test1'])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $admin->refresh();

        self::assertTrue($admin->hasRole('test1'));
        self::assertFalse($admin->hasAnyRole(['test2', 'test3', 'test4']));

        $this->actingAsAdmin()
            ->postJson('api/admin/admins/sync_roles/' . $admin['id'], ['roles' => ['test3', 'test4']])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $admin->refresh();

        self::assertTrue($admin->hasAllRoles(['test3', 'test4']));
        self::assertFalse($admin->hasAnyRole(['test1', 'test2']));
    }
}
