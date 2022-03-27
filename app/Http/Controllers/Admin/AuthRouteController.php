<?php

namespace App\Http\Controllers\Admin;

use App\Models\AuthRoute;
use App\Support\Routing\BaseController;
use Illuminate\Http\JsonResponse;

/**
 * @title 权限路由管理
 */
class AuthRouteController extends BaseController
{
    /**
     * @title 获取权限路由列表
     *
     * @param AuthRoute $authRoute
     *
     * @return JsonResponse
     */
    public function index(AuthRoute $authRoute): JsonResponse
    {
        $routes = $authRoute->lister();

        return $this->success('获取权限路由列表成功', $routes);
    }
}
