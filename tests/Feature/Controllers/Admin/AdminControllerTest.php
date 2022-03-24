<?php

namespace Tests\Feature\Controllers\Admin;

use App\Exceptions\ErrorCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\AdminActing;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function test_index()
    {
        $this->seedAdmin();

        $this->actingAsAdmin()
            ->getJson('api/admin/admins')
            ->assertJsonPath('data.data.0.id', 1)
            ->assertJsonPath('code', 0)
            ->assertOk();
    }

    public function test_store_validation()
    {
        $this->seedAdmin();

        $this->actingAsAdmin()
            ->postJson('api/admin/admins', ['username' => 'admin1'])
            ->assertJsonStructure(['message', 'errors' =>['name', 'password']])
            ->assertStatus(422);

        $this->actingAsAdmin()
            ->postJson('api/admin/admins', ['username' => 'admin', 'name' => 'Admin'])
            ->assertJsonStructure(['message', 'errors' =>['password', 'username', 'name']])
            ->assertStatus(422);
    }

    public function test_store()
    {
        $this->seedAdmin();

        $this->actingAsAdmin()
            ->postJson('api/admin/admins', ['username' => 'admin1', 'name' => 'Admin1', 'password' => 'admin.123'])
            ->assertJsonPath('data.username', 'admin1')
            ->assertOk();
    }

    public function test_update_validation()
    {
        $this->seedAdmin();

        $admin1 = $this->getAdmin(['id' =>1]);
        $admin2 = $this->getAdmin(['id' =>2]);

        $this->actingAsAdmin()
            ->putJson('api/admin/admins/'.$admin1['id'], ['username' => 'new username'])
            ->assertJsonStructure(['message', 'errors' => ['name']])
            ->assertStatus(422);

        $this->actingAsAdmin()
            ->putJson('api/admin/admins/'.$admin1['id'], ['username' => $admin2['username'], 'name' => $admin2['name']])
            ->assertJsonStructure(['message', 'errors' => ['name', 'username']])
            ->assertStatus(422);
    }

    public function test_update()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin(false);
        $superAdmin = $this->getAdmin(true);

        // 修改账号和名称
        $this->actingAsAdmin($admin)
            ->putJson('api/admin/admins/'. $admin['id'], ['username' => 'new username', 'name' => 'new name'])
            ->assertJsonPath('data.username', 'new username')
            ->assertJsonPath('data.name', 'new name')
            ->assertOk();

        // 修改密码
        $this->actingAsAdmin($admin)
            ->putJson('api/admin/admins/'. $admin['id'], ['username' => 'new username', 'name' => 'new name', 'password' => 'admin.222'])
            ->assertJsonPath('data.username', 'new username')
            ->assertJsonPath('data.name', 'new name')
            ->assertOk();

        $admin->refresh();

        self::assertEquals('new username', $admin['username']);
        self::assertEquals('new name', $admin['name']);

        self::assertTrue(Hash::check('admin.222', $admin['password']));
    }

    public function test_common_admin_can_not_update_super_admin()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin(false);
        $superAdmin = $this->getAdmin(true);

        $originSuperAdmin = $superAdmin->toArray();

        $this->actingAsAdmin($admin)
            ->putJson('api/admin/admins/'. $superAdmin['id'], ['username' => 'new username', 'name' => 'new name', 'password' => 'new password'])
            ->assertJsonPath('code', ErrorCode::SUPER_ADMIN_UPDATE_ERROR->value)
            ->assertOk();

        $superAdmin->refresh();
        self::assertEquals($originSuperAdmin['username'], $superAdmin['username']);
        self::assertTrue(Hash::check('admin.123', $superAdmin['password']));
    }

    public function test_super_admin_can_update_super_admin()
    {
        $this->seedAdmin();

        $superAdmin = $this->getAdmin(true);

        $this->actingAsAdmin($superAdmin)
            ->putJson('api/admin/admins/'. $superAdmin['id'], ['username' => 'new username', 'name' => 'new name', 'password' => 'new password'])
            ->assertJsonPath('code', ErrorCode::OK->value)
            ->assertOk();

        $superAdmin->refresh();
        self::assertEquals('new username', $superAdmin['username']);
        self::assertEquals('new name', $superAdmin['name']);
        self::assertTrue(Hash::check('new password', $superAdmin['password']));
    }

    public function test_show()
    {
        $this->seedAdmin();
        $admin = $this->getAdmin();

        $this->actingAsAdmin($admin)
            ->getJson('api/admin/admins/'. $admin['id'])
            ->assertJsonPath('data.id', $admin['id'])
            ->assertOk();
    }

    public function test_show_not_exists()
    {
        $this->seedAdmin();

        $this->actingAsAdmin()
            ->getJson('api/admin/admins/33343')
            ->assertNotFound();
    }

    public function test_destroy_common_admin()
    {
        $this->seedAdmin();

        $commonAdmin = $this->getAdmin(false);
        $superAdmin = $this->getAdmin(true);

        $this->actingAsAdmin($superAdmin)
            ->deleteJson('api/admin/admins/'.$commonAdmin['id'])
            ->assertJsonPath('code', 0)
            ->assertOk();

        $this->assertDatabaseMissing('admins', ['id' => $commonAdmin['id']]);
    }

    public function test_destroy_super_admin()
    {
        $this->seedAdmin();

        $superAdmin = $this->getAdmin(true);

        $this->actingAsAdmin($superAdmin)
            ->deleteJson('api/admin/admins/'.$superAdmin['id'])
            ->assertJsonPath('code', ErrorCode::SUPER_ADMIN_DELETE_ERROR->value)
            ->assertOk();

        $this->assertDatabaseHas('admins', ['id' => $superAdmin['id']]);
    }
}
