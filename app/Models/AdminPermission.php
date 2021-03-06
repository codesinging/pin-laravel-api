<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Models;

use App\Support\Model\PermissionContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class AdminPermission extends Permission
{
    protected string $guard_name = 'sanctum';

    /**
     * 根据指定的模型生成权限名
     *
     * @param Model $model
     *
     * @return string
     */
    public static function createName(Model $model): string
    {
        return sprintf('%s:%s', $model::class, $model['id']);
    }

    /**
     * 根据指定的模型创建对应的权限
     *
     * @param Model|PermissionContract $model
     *
     * @return Builder|Model
     */
    public static function createFrom(Model|PermissionContract $model): Model|Builder
    {
        $permission = self::create([
            'name' => self::createName($model),
        ]);

        $model->permission()->associate($permission)->save();

        return $permission;
    }

    /**
     * 根据指定的系统模型查找关联的权限
     *
     * @param Model $model
     *
     * @return \Spatie\Permission\Contracts\Permission
     */
    public static function findFrom(Model $model): \Spatie\Permission\Contracts\Permission
    {
        return self::findByName(self::createName($model));
    }

    /**
     * 删除指定的模型对应的权限
     *
     * @param Model $model
     *
     * @return bool|null
     */
    public static function deleteFrom(Model $model): ?bool
    {
        return self::findFrom($model)->delete();
    }
}
