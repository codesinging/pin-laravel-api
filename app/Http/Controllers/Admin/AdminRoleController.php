<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminRoleRequest;
use App\Models\AdminRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class AdminRoleController extends Controller
{
    /**
     * @title 获取后台角色列表
     *
     * @param AdminRole $adminRole
     *
     * @return JsonResponse
     */
    public function index(AdminRole $adminRole): JsonResponse
    {
        $roles = $adminRole->lister(function (Builder $builder) {
            $builder->orderByDesc('sort');
        });

        return $this->success('获取角色列表成功', $roles);
    }

    /**
     * @title 新增后台角色
     *
     * @param AdminRoleRequest $request
     * @param AdminRole $adminRole
     *
     * @return JsonResponse
     */
    public function store(AdminRoleRequest $request, AdminRole $adminRole): JsonResponse
    {
        $request->validate([
            'name' => 'unique:'.$adminRole->getTable(),
        ], [], $request->attributes());

        return $adminRole->sanitizeFill($request)->save()
            ? $this->success('新增成功', $adminRole)
            : $this->error('新增失败');
    }

    /**
     * @title 更新后台角色
     *
     * @param AdminRoleRequest $request
     * @param AdminRole $adminRole
     *
     * @return JsonResponse
     */
    public function update(AdminRoleRequest $request, AdminRole $adminRole): JsonResponse
    {
        $request->validate([
            'name' => Rule::unique($adminRole->getTable())->ignore($adminRole),
        ], [], $request->attributes());

        return $adminRole->sanitizeFill($request)->save()
            ? $this->success('更新成功', $adminRole)
            : $this->error('更新失败');
    }

    /**
     * @title 获取后台角色详情
     *
     * @param AdminRole $adminRole
     *
     * @return JsonResponse
     */
    public function show(AdminRole $adminRole): JsonResponse
    {
        return $this->success('获取后台角色详情成功', $adminRole);
    }

    /**
     * @title 删除后台角色
     *
     * @param AdminRole $adminRole
     *
     * @return JsonResponse
     */
    public function destroy(AdminRole $adminRole): JsonResponse
    {
        return $adminRole->delete()
            ? $this->success('删除成功', $adminRole)
            : $this->error('删除失败');
    }

    /**
     * @title 获取角色权限
     *
     * @param AdminRole $role
     *
     * @return JsonResponse
     */
    public function permissions(AdminRole $role): JsonResponse
    {
        $permissions = $role->getAllPermissions();

        return $this->success('获取权限成功', $permissions);
    }

    /**
     * @title 设置角色权限
     *
     * @param AdminRole $role
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function permission(AdminRole $role, Request $request): JsonResponse
    {
        $role->syncPermissions(Arr::wrap($request->get('permissions', [])));

        return $this->success('设置权限成功');
    }
}
