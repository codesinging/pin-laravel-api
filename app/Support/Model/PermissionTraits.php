<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

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
}
