<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Models;

use Spatie\Permission\Models\Role;

class AdminAuthRole extends Role
{
    protected string $guard_name = 'sanctum';

    /**
     * 根据指定的系统角色模型生成权限角色名
     *
     * @param AdminRole $role
     *
     * @return string
     */
    public static function createName(AdminRole $role): string
    {
        return sprintf('%s:%s', $role::class, $role['id']);
    }

    /**
     * 根据指定的系统角色模型生成权限角色
     *
     * @param AdminRole $role
     *
     * @return void
     */
    public static function createFrom(AdminRole $role)
    {
        self::create([
            'name' => self::createName($role),
        ]);
    }
}
