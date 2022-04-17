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
     * @title 获取路由列表
     *
     * @param AdminRoute $adminRoute
     *
     * @return JsonResponse
     */
    public function index(AdminRoute $adminRoute): JsonResponse
    {
        $routes = $adminRoute->lister();

        return $this->success('获取路由权限列表成功', $routes);
    }

    /**
     * @title 获取路由详情
     *
     * @param AdminRoute $adminRoute
     *
     * @return JsonResponse
     */
    public function show(AdminRoute $adminRoute): JsonResponse
    {
        return $this->success('获取路由详情成功', $adminRoute);
    }
}
