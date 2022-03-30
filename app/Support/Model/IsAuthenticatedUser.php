<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use Illuminate\Support\Facades\Auth;

trait IsAuthenticatedUser
{
    /**
     * 是否当前认证的管理员
     *
     * @return bool
     */
    public function isAuthenticatedUser(): bool
    {
        return Auth::id() === $this['id'];
    }

}
