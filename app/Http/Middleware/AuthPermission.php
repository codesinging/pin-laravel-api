<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Http\Middleware;

use App\Models\AdminRoute;
use App\Support\Model\AuthModel;
use Illuminate\Http\Request;

class AuthPermission
{
    public function handle(Request $request, \Closure $next)
    {
        /** @var AuthModel $user */
        $user = $request->user();

        $adminRoute = AdminRoute::findFrom($request->route());
        if ($adminRoute) {
            if ($user->cannot($adminRoute['permission']['name'])) {
                abort(403, '无访问权限');
            }
        }

        return $next($request);
    }
}
