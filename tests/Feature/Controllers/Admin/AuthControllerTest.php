<?php

namespace Tests\Feature\Controllers\Admin;

use App\Exceptions\ErrorCode;
use App\Models\Admin;
use App\Models\AdminMenu;
use App\Models\AdminPage;
use Database\Seeders\AdminMenuSeeder;
use Database\Seeders\AdminPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Tests\AdminActing;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function testLoginValidate()
    {
        $this->postJson('api/admin/auth/login', [])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['username', 'password']]);
    }

    public function testLoginUserNotExists()
    {
        $this->postJson('api/admin/auth/login', ['username' => 'not_exists', 'password' => '111111'])
            ->assertOk()
            ->assertJsonPath('code', ErrorCode::AUTH_USER_NOT_EXISTED);
    }

    public function testLoginPasswordNotMatched()
    {
        $this->seedAdmin();
        $this->postJson('api/admin/auth/login', ['username' => 'admin', 'password' => '111111'])
            ->assertOk()
            ->assertJsonPath('code', ErrorCode::AUTH_PASSWORD_NOT_MATCHED);
    }

    public function testLoginUserStatusError()
    {
        $this->seedAdmin();
        $admin = $this->getAdmin();

        $admin->fill(['status' => false]);

        $admin->save();

        $this->postJson('api/admin/auth/login', ['username' => $admin['username'], 'password' => 'admin.123'])
            ->assertOk()
            ->assertJsonPath('code', ErrorCode::AUTH_USER_STATUS_ERROR);
    }

    public function testLogin()
    {
        $this->seedAdmin();

        $this->postJson('api/admin/auth/login', ['username' => 'admin', 'password' => 'admin.123'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonStructure(['code', 'data' => ['admin', 'token']])
            ->assertJsonPath('data.admin.username', 'admin');
    }

    public function testLogout()
    {
        $this->seedAdmin();
        $admin = $this->getAdmin();

        $this->postJson('api/admin/auth/login', ['username' => $admin['username'], 'password' => 'admin.123'])
            ->assertOk();

        Auth::login($admin);

        /** @var Admin $user */
        $user = Auth::user();

        self::assertCount(1, $user->tokens()->get()->toArray());

        $this->actingAsAdmin($admin)->postJson('api/admin/auth/logout')
            ->assertOk();

        self::assertCount(0, $user->tokens()->get()->toArray());
    }

    public function testUser()
    {
        $this->seedAdmin();
        $admin = $this->getAdmin();

        $this->actingAsAdmin($admin)
            ->getJson('api/admin/auth/user')
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $admin['id']);
    }

    public function testPagesUsingSuperAdmin()
    {
        $this->seed(AdminPageSeeder::class);

        $adminPages = AdminPage::new()->where('status', true)->get();

        $this->seedAdmin()
            ->actingAsAdmin(true)
            ->getJson('api/admin/auth/pages')
            ->assertJsonPath('code', 0)
            ->assertJsonPath("data.0.id", $adminPages->first()['id'])
            ->assertJsonCount($adminPages->count(), 'data')
            ->assertOk();
    }

    public function testPagesUsingCommonAdmin()
    {
        $this->seed(AdminPageSeeder::class);
        $this->seedAdmin();

        $adminPages = AdminPage::new()->where('status', true)->get();

        $admin = $this->getAdmin(false);

        $this->actingAsAdmin($admin)
            ->getJson('api/admin/auth/pages')
            ->assertJsonPath('code', 0)
            ->assertJsonCount(0, "data")
            ->assertOk();

        $admin->givePermissionTo($adminPages->first()['permission_id']);

        $this->actingAsAdmin($admin)
            ->getJson('api/admin/auth/pages')
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('code', 0)
            ->assertJsonPath("data.0.id", $adminPages->first()['id'])
            ->assertJsonCount(1, 'data')
            ->assertOk();
    }

    public function testPagesWhenDisabledPermission()
    {
        Config::set('permission.disabled', true);
        $this->seed(AdminPageSeeder::class);

        $adminPages = AdminPage::new()->where('status', true)->get();

        $this->seedAdmin()
            ->actingAsAdmin(false)
            ->getJson('api/admin/auth/pages')
            ->assertJsonPath('code', 0)
            ->assertJsonCount($adminPages->count(), 'data')
            ->assertJsonPath("data.0.id", $adminPages->first()['id'])
            ->assertOk();
    }

    public function testMenusUsingSuperAdmin()
    {
        $this->seed(AdminMenuSeeder::class);

        $adminMenus = AdminMenu::new()->where('status', true)->get();

        $this->seedAdmin()
            ->actingAsAdmin(true)
            ->getJson('api/admin/auth/menus')
            ->assertJsonPath('code', 0)
            ->assertJsonPath("data.0.id", $adminMenus->first()['id'])
            ->assertJsonCount($adminMenus->count(), 'data')
            ->assertOk();
    }

    public function testMenusUsingCommonAdmin()
    {
        $this->seed(AdminMenuSeeder::class);
        $this->seedAdmin();

        $adminMenus = AdminMenu::new()->where('status', true)->get();

        $admin = $this->getAdmin(false);

        $this->actingAsAdmin($admin)
            ->getJson('api/admin/auth/menus')
            ->assertJsonPath('code', 0)
            ->assertJsonCount(0, "data")
            ->assertOk();

        $admin->givePermissionTo($adminMenus->first()['permission_id']);

        $this->actingAsAdmin($admin)
            ->getJson('api/admin/auth/menus')
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('code', 0)
            ->assertJsonPath("data.0.id", $adminMenus->first()['id'])
            ->assertJsonCount(1, 'data')
            ->assertOk();
    }

    public function testMenusWhenDisabledPermission()
    {
        Config::set('permission.disabled', true);

        $this->seed(AdminMenuSeeder::class);

        $adminMenus = AdminMenu::new()->where('status', true)->get();

        $this->seedAdmin()
            ->actingAsAdmin(false)
            ->getJson('api/admin/auth/menus')
            ->assertJsonPath('code', 0)
            ->assertJsonPath("data.0.id", $adminMenus->first()['id'])
            ->assertJsonCount($adminMenus->count(), 'data')
            ->assertOk();
    }
}
