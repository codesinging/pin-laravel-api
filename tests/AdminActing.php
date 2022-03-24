<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests;

use App\Models\Admin;
use Database\Seeders\AdminSeeder;

trait AdminActing
{
    /**
     * 获取一个管理员
     *
     * @param string|bool|array|null $admin
     *
     * @return Admin
     */
    protected function getAdmin(string|bool|array $admin = null): Admin
    {
        if (is_string($admin)) {
            return Admin::new()->where('username', $admin)->first();
        } elseif (is_array($admin)) {
            return Admin::new()->where($admin)->first();
        } elseif (is_bool($admin)) {
            return Admin::new()->where('super', $admin)->first();
        } else {
            return Admin::new()->first();
        }
    }

    /**
     * 以管理员身份登录
     *
     * @param string|bool|array|null $admin
     *
     * @return $this
     */
    protected function actingAsAdmin(string|bool|array $admin = null): static
    {
        $this->actingAs($this->getAdmin($admin));
        return $this;
    }

    /**
     * 填充管理员数据
     *
     * @return $this
     */
    protected function seedAdmin(): static
    {
        if (!property_exists($this, 'seed') || $this->seed === false) {
            $this->seed(AdminSeeder::class);
        }

        return $this;
    }
}
