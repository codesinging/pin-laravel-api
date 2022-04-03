<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminMenuRequest;
use App\Models\AdminMenu;
use App\Support\Routing\BaseController;
use Illuminate\Http\JsonResponse;

/**
 * @title 后台菜单管理
 */
class AdminMenuController extends BaseController
{
    /**
     * @title 获取菜单列表
     *
     * @param AdminMenu $menu
     *
     * @return JsonResponse
     */
    public function index(AdminMenu $menu): JsonResponse
    {
        $menus = $menu->orderByDesc('sort')->get()->toTree();
        return $this->success('获取菜单列表成功', $menus);
    }

    /**
     * @title 新增后台菜单
     *
     * @param AdminMenuRequest $request
     * @param AdminMenu $adminMenu
     *
     * @return JsonResponse
     */
    public function store(AdminMenuRequest $request, AdminMenu $adminMenu): JsonResponse
    {
        if ($parentId = $request->get('parent_id')) {
            $parentMenu = AdminMenu::new()->find($parentId);
            $menu = AdminMenu::create($adminMenu->sanitize($request), $parentMenu);
        } else {
            $menu = AdminMenu::create($adminMenu->sanitize($request));
        }

        return $this->success('新增成功', $menu);
    }

    /**
     * @title 更新后台菜单
     *
     * @param AdminMenuRequest $request
     * @param AdminMenu $adminMenu
     *
     * @return JsonResponse
     */
    public function update(AdminMenuRequest $request, AdminMenu $adminMenu): JsonResponse
    {
        $adminMenu->sanitizeFill($request)->save();

        $newParentId = $request['parent_id'];
        $oldParentId = $adminMenu['parent_id'];

        if ($newParentId !== $oldParentId) {
            if (is_null($newParentId)) {
                $adminMenu->saveAsRoot();
            } else {
                $adminMenu->appendToNode(AdminMenu::new()->find($newParentId))->save();
            }
        }

        return $this->success('更新成功', $adminMenu);
    }

    /**
     * @title 获取后台菜单详情
     *
     * @param AdminMenu $adminMenu
     *
     * @return JsonResponse
     */
    public function show(AdminMenu $adminMenu): JsonResponse
    {
        return $this->success('获取详情成功', $adminMenu);
    }

    /**
     * @title 删除后台菜单
     *
     * @param AdminMenu $adminMenu
     *
     * @return JsonResponse
     */
    public function destroy(AdminMenu $adminMenu): JsonResponse
    {
        return $adminMenu->delete()
            ? $this->success('删除成功')
            : $this->error('删除失败');
    }
}
