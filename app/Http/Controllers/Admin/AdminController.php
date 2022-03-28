<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\ErrorCode;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Support\Routing\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminController extends BaseController
{
    /**
     * @title 获取管理员列表
     *
     * @param Admin $admin
     *
     * @return JsonResponse
     */
    public function index(Admin $admin): JsonResponse
    {
        $lister = $admin->lister();

        return $this->success($lister);
    }

    /**
     * @title 新增管理员
     *
     * @param AdminRequest $request
     * @param Admin $admin
     *
     * @return JsonResponse
     */
    public function store(AdminRequest $request, Admin $admin): JsonResponse
    {
        $request->validate([
            'password' => 'required',
            'username' => 'unique:admins',
            'name' => 'unique:admins',
        ], [], $request->attributes());

        return $admin->sanitizeFill($request)->save()
            ? $this->success('新增成功', $admin)
            : $this->error('新增失败');
    }

    /**
     * @title 更新管理员
     *
     * @param AdminRequest $request
     * @param Admin $admin
     *
     * @return JsonResponse
     */
    public function update(AdminRequest $request, Admin $admin): JsonResponse
    {
        if ($admin->isSuper() && !$admin->isAuthenticatedUser()) {
            return $this->error('无操作权限', ErrorCode::SUPER_ADMIN_UPDATE_ERROR);
        }

        $request->validate([
            'username' => Rule::unique('admins')->ignore($admin),
            'name' => Rule::unique('admins')->ignore($admin),
        ], [], $request->attributes());

        return $admin->sanitizeFill($request)->save()
            ? $this->success('更新成功', $admin)
            : $this->error('更新失败');
    }

    /**
     * @title 查看管理员详情
     *
     * @param Admin $admin
     *
     * @return JsonResponse
     */
    public function show(Admin $admin): JsonResponse
    {
        return $this->success($admin);
    }

    /**
     * @title 删除管理员
     *
     * @param Admin $admin
     *
     * @return JsonResponse
     */
    public function destroy(Admin $admin): JsonResponse
    {
        if ($admin->isSuper()) {
            return $this->error('超级管理员无法删除', ErrorCode::SUPER_ADMIN_DELETE_ERROR);
        }

        return $admin->delete()
            ? $this->success('删除成功')
            : $this->error('删除失败');
    }
}
