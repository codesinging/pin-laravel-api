<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
     * @return Builder|Model
     */
    public static function createFrom(AdminRole $role): Model|Builder
    {
        return self::create([
            'name' => self::createName($role),
        ]);
    }

    /**
     * 根据指定的系统角色模型同步权限模型
     *
     * @param AdminRole $role
     *
     * @return \Spatie\Permission\Contracts\Role
     */
    public static function syncFrom(AdminRole $role): \Spatie\Permission\Contracts\Role
    {
        return self::findOrCreate(self::createName($role));
    }
}
