<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class AdminAuthPermission extends Permission
{
    protected string $guard_name = 'sanctum';

    /**
     * 根据指定的模型生成权限名
     *
     * @param AdminRoute|AdminPage|AdminMenu $model
     *
     * @return string
     */
    public static function createName(AdminRoute|AdminPage|AdminMenu $model): string
    {
        return sprintf('%s:%s', $model::class, $model['id']);
    }

    /**
     * 根据指定的模型创建对应的权限
     *
     * @param AdminRoute|AdminPage|AdminMenu $model
     *
     * @return Builder|Model
     */
    public static function createFrom(AdminRoute|AdminPage|AdminMenu $model): Model|Builder
    {
        return self::create([
            'name' => self::createName($model),
        ]);
    }

    /**
     * 根据指定的模型创建对应的权限
     *
     * @param AdminRoute|AdminPage|AdminMenu $model
     *
     * @return \Spatie\Permission\Contracts\Permission
     */
    public static function syncFrom(AdminRoute|AdminPage|AdminMenu $model): \Spatie\Permission\Contracts\Permission
    {
        return self::findOrCreate(self::createName($model));
    }
}
