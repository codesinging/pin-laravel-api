<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminPageRequest;
use App\Models\AdminPage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

/**
 * @title 后台页面管理
 */
class AdminPageController extends Controller
{
    /**
     * @title 获取后台页面列表
     *
     * @param AdminPage $adminPage
     *
     * @return JsonResponse
     */
    public function index(AdminPage $adminPage): JsonResponse
    {
        $pages = $adminPage->lister(function (Builder $builder) {
            $builder->orderByDesc('sort');
        });

        return $this->success('获取页面列表成功', $pages);
    }

    /**
     * @title 新增后台页面
     *
     * @param AdminPageRequest $request
     * @param AdminPage $adminPage
     *
     * @return JsonResponse
     */
    public function store(AdminPageRequest $request, AdminPage $adminPage): JsonResponse
    {
        $request->validate([
            'path' => 'unique:admin_pages',
        ], [], $request->attributes());

        return $adminPage->sanitizeFill($request)->save()
            ? $this->success('新增成功', $adminPage)
            : $this->error('新增失败');
    }

    /**
     * @title 更新后台页面
     *
     * @param AdminPageRequest $request
     * @param AdminPage $adminPage
     *
     * @return JsonResponse
     */
    public function update(AdminPageRequest $request, AdminPage $adminPage): JsonResponse
    {
        $request->validate([
            'path' => Rule::unique('admin_pages')->ignore($adminPage),
        ], [], $request->attributes());

        return $adminPage->sanitizeFill($request)->save()
            ? $this->success('更新成功', $adminPage)
            : $this->error('更新失败');
    }

    /**
     * @title 获取后台页面详情
     *
     * @param AdminPage $adminPage
     *
     * @return JsonResponse
     */
    public function show(AdminPage $adminPage): JsonResponse
    {
        return $this->success('获取页面详情成功', $adminPage);
    }

    /**
     * @title 删除后台页面
     *
     * @param AdminPage $adminPage
     *
     * @return JsonResponse
     */
    public function destroy(AdminPage $adminPage): JsonResponse
    {
        return $adminPage->delete()
            ? $this->success('删除成功', $adminPage)
            : $this->error('删除失败');
    }
}
