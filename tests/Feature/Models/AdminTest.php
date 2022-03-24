<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\AdminActing;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use AdminActing;
    use RefreshDatabase;

    public function test_update_admin_with_password_attribute()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin();

        $admin->fill(['password' => 'admin.111'])->save();

        $admin->refresh();

        self::assertFalse(Hash::check('admin.123', $admin['password']));
        self::assertTrue(Hash::check('admin.111', $admin['password']));
    }

    public function test_update_admin_without_password_attribute()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin();

        $admin->fill(['name' => 'AdminNew'])->save();

        $admin->refresh();

        self::assertTrue(Hash::check('admin.123', $admin['password']));
        self::assertEquals('AdminNew', $admin['name']);
    }

    public function test_is_super()
    {
        $this->seedAdmin();

        self::assertFalse($this->getAdmin(false)->isSuper());
        self::assertTrue($this->getAdmin(true)->isSuper());
    }
}
