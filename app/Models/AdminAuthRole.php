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
     * @param Model $model
     *
     * @return string
     */
    public static function createName(Model $model): string
    {
        return sprintf('%s:%s', $model::class, $model['id']);
    }

    /**
     * 根据指定的系统角色模型生成权限角色
     *
     * @param Model $model
     *
     * @return Builder|Model
     */
    public static function createFrom(Model $model): Model|Builder
    {
        return self::create([
            'name' => self::createName($model),
        ]);
    }

    /**
     * 根据指定的系统角色模型同步权限角色
     *
     * @param Model $model
     *
     * @return \Spatie\Permission\Contracts\Role
     */
    public static function syncFrom(Model $model): \Spatie\Permission\Contracts\Role
    {
        return self::findOrCreate(self::createName($model));
    }

    /**
     * 根据系统角色模型查找关联的权限角色
     *
     * @param Model $model
     *
     * @return \Spatie\Permission\Contracts\Role|Role
     */
    public static function findFrom(Model $model): \Spatie\Permission\Contracts\Role|Role
    {
        return self::findByName(self::createName($model));
    }

    /**
     * 删除指定系统角色模型对应的权限角色
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
