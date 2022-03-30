<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait PermissionTraits
{
    /**
     * 获取指定模型类的所有权限
     *
     * @param string $class
     *
     * @return Collection
     */
    public function getPermissionsFrom(string $class): Collection
    {
        return $this->getAllPermissions()->filter(fn($permission) => str_starts_with($permission['name'], $class));
    }

    /**
     * 获取拥有权限的指定的模型集合
     *
     * @param string $class
     *
     * @return Collection
     */
    public function getPermittedModels(string $class): Collection
    {
        $permissions = $this->getPermissionsFrom($class);

        /** @var Model|AuthPermissionContract $model */
        $model = new $class();

        return $model->newQuery()->whereIn('permission_id', $permissions->pluck('id'))->get();
    }
}
