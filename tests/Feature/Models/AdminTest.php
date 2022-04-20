<?php

namespace Tests\Feature\Models;

use App\Models\AdminPermission;
use App\Models\AdminRole;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\AdminActing;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use AdminActing;
    use RefreshDatabase;

    public function testUpdateAdminWithPasswordAttribute()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin();

        $admin->fill(['password' => 'admin.111'])->save();

        $admin->refresh();

        self::assertFalse(Hash::check('admin.123', $admin['password']));
        self::assertTrue(Hash::check('admin.111', $admin['password']));
    }

    public function testUpdateAdminWithoutPasswordAttribute()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin();

        $admin->fill(['name' => 'AdminNew'])->save();

        $admin->refresh();

        self::assertTrue(Hash::check('admin.123', $admin['password']));
        self::assertEquals('AdminNew', $admin['name']);
    }

    public function testIsSuper()
    {
        $this->seedAdmin();

        self::assertFalse($this->getAdmin(false)->isSuper());
        self::assertTrue($this->getAdmin(true)->isSuper());
    }

    /**
     * @throws Exception
     */
    public function testGiveDirectPermissions()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin(false);

        $permissions = [
            ['name' => 'permission1'],
            ['name' => 'permission2'],
            ['name' => 'permission3'],
        ];

        foreach ($permissions as $permission) {
            AdminPermission::create($permission);
        }

        $admin->givePermissionTo(['permission1']);
        $admin->givePermissionTo('permission3');

        self::assertTrue($admin->hasAllPermissions(['permission1', 'permission3']));
        self::assertFalse($admin->hasAnyPermission(['permission2']));

        self::assertTrue($admin->can('permission1'));
        self::assertTrue($admin->can(['permission3']));
        self::assertFalse($admin->can('permission2'));
    }

    public function testAssignRoles()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin(false);

        $roles = [
            ['name' => 'role1'],
            ['name' => 'role2'],
            ['name' => 'role3'],
        ];

        foreach ($roles as $role) {
            AdminRole::create($role);
        }

        $admin->assignRole('role1');
        $admin->assignRole(['role1', 'role3']);

        self::assertTrue($admin->hasAllRoles(['role1', 'role3']));
        self::assertFalse($admin->hasAnyRole('role2'));
    }

    /**
     * @throws Exception
     */
    public function testGivePermissionsViaRoles()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin(false);

        $roles = [
            ['name' => 'role1'],
            ['name' => 'role2'],
            ['name' => 'role3'],
        ];

        foreach ($roles as $role) {
            AdminRole::create($role);
        }

        $permissions = [
            ['name' => 'permission1'],
            ['name' => 'permission2'],
            ['name' => 'permission3'],
            ['name' => 'permission4'],
        ];

        foreach ($permissions as $permission) {
            AdminPermission::create($permission);
        }

        $admin->assignRole('role1');
        $admin->assignRole(['role3']);

        $role1 = AdminRole::findByName('role1');
        $role3 = AdminRole::findByName('role3');

        $role1->givePermissionTo('permission1');
        $role3->givePermissionTo(['permission3', 'permission4']);

        self::assertTrue($admin->hasAllRoles(['role1', 'role3']));
        self::assertFalse($admin->hasAnyRole('role2'));

        self::assertTrue($admin->hasAllPermissions(['permission1', 'permission3', 'permission4']));
        self::assertFalse($admin->hasAnyPermission(['permission2']));

        self::assertTrue($admin->can(['permission1', 'permission3', 'permission4']));
        self::assertFalse($admin->can(['permission2']));
    }

    /**
     * @throws Exception
     */
    public function testCommonAndSuperAdminPermission()
    {
        $this->seedAdmin();

        $commonAdmin = $this->getAdmin(false);
        $superAdmin = $this->getAdmin(true);

        $permissions = [
            ['name' => 'permission1'],
            ['name' => 'permission2'],
            ['name' => 'permission3'],
            ['name' => 'permission4'],
        ];

        foreach ($permissions as $permission) {
            AdminPermission::create($permission);
        }

        self::assertFalse($commonAdmin->can(['permission1', 'permission2', 'permission3', 'permission4']));
        self::assertTrue($superAdmin->can(['permission1', 'permission2', 'permission3', 'permission4']));
    }
}
