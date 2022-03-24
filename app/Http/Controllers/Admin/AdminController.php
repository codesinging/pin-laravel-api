<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\ErrorCode;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
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
     * @param AdminStoreRequest $request
     * @param Admin $admin
     *
     * @return JsonResponse
     */
    public function store(AdminStoreRequest $request, Admin $admin): JsonResponse
    {
        return $admin->sanitizeFill($request)->save()
            ? $this->success('新增成功', $admin)
            : $this->error('新增失败');
    }

    /**
     * @throws ValidationException
     */
    public function update(AdminUpdateRequest $request, Admin $admin): JsonResponse
    {
        if ($admin->isSuper() && !$admin->isAuthenticatedUser()) {
            return $this->error('无操作权限', ErrorCode::SUPER_ADMIN_UPDATE_ERROR);
        }

        $this->validate($request, [
            'username' => $admin->uniqueRule(),
            'name' => $admin->uniqueRule(),
        ]);

        return $admin->sanitizeFill($request)->save()
            ? $this->success('更新成功', $admin)
            : $this->error('更新失败');
    }
}
