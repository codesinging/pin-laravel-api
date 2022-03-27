<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminRoute;
use App\Support\Routing\BaseController;
use Illuminate\Http\JsonResponse;

/**
 * @title 后台路由权限管理
 */
class AdminRouteController extends BaseController
{
    /**
     * @title 获取路由权限列表
     *
     * @param AdminRoute $authRoute
     *
     * @return JsonResponse
     */
    public function index(AdminRoute $authRoute): JsonResponse
    {
        $routes = $authRoute->lister();

        return $this->success('获取路由权限列表成功', $routes);
    }
}
