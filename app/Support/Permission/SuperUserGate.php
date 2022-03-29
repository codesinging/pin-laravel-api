<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Permission;

use App\Support\Model\AuthModel;
use App\Support\Model\IsSuperContract;
use Illuminate\Support\Facades\Gate;

trait SuperUserGate
{
    /**
     * 处理超级用户权限
     *
     * @return void
     */
    protected function handleSuperUser()
    {
        Gate::before(function (AuthModel|IsSuperContract $user) {
            return $user->isSuper() ? true : null;
        });

        Gate::after(function (AuthModel|IsSuperContract $user) {
            return $user->isSuper();
        });
    }
}
