<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

interface IsSuperContract
{
    /**
     * 是否超级用户（拥有所有权限）
     *
     * @return bool
     */
    public function isSuper(): bool;
}
