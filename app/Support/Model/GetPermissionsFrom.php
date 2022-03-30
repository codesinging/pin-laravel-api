<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use Illuminate\Support\Collection;

trait GetPermissionsFrom
{
    /**
     * 获取指定模型类的所有权限
     *
     * @param string $model
     *
     * @return Collection
     */
    public function getPermissionsFrom(string $model): Collection
    {
        return $this->getAllPermissions()->filter(fn($permission) => str_starts_with($permission['name'], $model));
    }
}
