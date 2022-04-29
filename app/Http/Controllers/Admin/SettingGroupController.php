<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SettingGroupRequest;
use App\Models\SettingGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

/**
 * @title 设置分组管理
 */
class SettingGroupController extends Controller
{
    /**
     * @title 获取设置分组列表
     *
     * @param SettingGroup $settingGroup
     *
     * @return JsonResponse
     */
    public function index(SettingGroup $settingGroup): JsonResponse
    {
        $lister = $settingGroup->lister(function (Builder $builder) {
            $builder->orderByDesc('sort');
        });

        return $this->success('获取设置分组成功', $lister);
    }

    /**
     * @title 新增设置分组
     *
     * @param SettingGroupRequest $request
     * @param SettingGroup $settingGroup
     *
     * @return JsonResponse
     */
    public function store(SettingGroupRequest $request, SettingGroup $settingGroup): JsonResponse
    {
        $this->validateUnique('name', $request, $settingGroup);

        return $settingGroup->sanitizeFill($request)->save()
            ? $this->success('新增成功', $settingGroup)
            : $this->error('新增失败');
    }

    /**
     * @title 更新设置分组
     *
     * @param SettingGroupRequest $request
     * @param SettingGroup $settingGroup
     *
     * @return JsonResponse
     */
    public function update(SettingGroupRequest $request, SettingGroup $settingGroup): JsonResponse
    {
        $this->validateUnique('name', $request, $settingGroup);

        return $settingGroup->sanitizeFill($request)->save()
            ? $this->success('更新成功', $settingGroup)
            : $this->error('更新失败');
    }

    /**
     * @title 查看设置分组详情
     *
     * @param SettingGroup $settingGroup
     *
     * @return JsonResponse
     */
    public function show(SettingGroup $settingGroup): JsonResponse
    {
        return $this->success('获取设置分组详情成功', $settingGroup);
    }

    /**
     * @title 删除设置分组
     *
     * @param SettingGroup $settingGroup
     *
     * @return JsonResponse
     */
    public function destroy(SettingGroup $settingGroup): JsonResponse
    {
        return $settingGroup->delete()
            ? $this->success('删除成功', $settingGroup)
            : $this->error('删除失败');
    }
}
