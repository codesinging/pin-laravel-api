<?php

namespace Tests\Feature\Controllers\Admin;

use App\Exceptions\ErrorCode;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\AdminActing;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function test_login_validation()
    {
        $this->postJson('api/admin/auth/login', [])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['username', 'password']]);
    }

    public function test_login_user_not_exists()
    {
        $this->postJson('api/admin/auth/login', ['username' => 'not_exists', 'password' => '111111'])
            ->assertOk()
            ->assertJsonPath('code', ErrorCode::AUTH_USER_NOT_EXISTED->value);
    }

    public function test_login_password_not_matched()
    {
        $this->seedAdmin();
        $this->postJson('api/admin/auth/login', ['username' => 'admin', 'password' => '111111'])
            ->assertOk()
            ->assertJsonPath('code', ErrorCode::AUTH_PASSWORD_NOT_MATCHED->value);
    }

    public function test_login_user_status_error()
    {
        $this->seedAdmin();
        $admin = $this->getAdmin();

        $admin->fill(['status' => false]);

        $admin->save();

        $this->postJson('api/admin/auth/login', ['username' => $admin['username'], 'password' => 'admin.123'])
            ->assertOk()
            ->assertJsonPath('code', ErrorCode::AUTH_USER_STATUS_ERROR->value);
    }

    public function test_login()
    {
        $this->seedAdmin();

        $this->postJson('api/admin/auth/login', ['username' => 'admin', 'password' => 'admin.123'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonStructure(['code', 'data' => ['admin', 'token']])
            ->assertJsonPath('data.admin.username', 'admin');
    }

    public function test_logout()
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

    public function test_user()
    {
        $this->seedAdmin();
        $admin = $this->getAdmin();

        $this->actingAsAdmin($admin)
            ->getJson('api/admin/auth/user')
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $admin['id']);
    }
}
