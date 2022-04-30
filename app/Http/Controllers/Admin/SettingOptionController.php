<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SettingOptionRequest;
use App\Models\SettingOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class SettingOptionController extends Controller
{
    /**
     * @title 获取设置列表
     *
     * @param SettingOption $settingOption
     *
     * @return JsonResponse
     */
    public function index(SettingOption $settingOption): JsonResponse
    {
        $lister = $settingOption->lister(function (Builder $builder) {
            $builder->orderByDesc('sort');
        });

        return $this->success('获取设置列表成功', $lister);
    }

    /**
     * @title 新增设置
     *
     * @param SettingOptionRequest $request
     * @param SettingOption $settingOption
     *
     * @return JsonResponse
     */
    public function store(SettingOptionRequest $request, SettingOption $settingOption): JsonResponse
    {
        $this->validateUnique('name', $request, $settingOption);

        return $settingOption->sanitizeFill($request)->save()
            ? $this->success('新增成功', $settingOption)
            : $this->error('新增失败');
    }

    /**
     * @title 更新设置
     *
     * @param SettingOptionRequest $request
     * @param SettingOption $settingOption
     *
     * @return JsonResponse
     */
    public function update(SettingOptionRequest $request, SettingOption $settingOption): JsonResponse
    {
        $this->validateUnique('name', $request, $settingOption);

        return $settingOption->sanitizeFill($request)->save()
            ? $this->success('更新成功', $settingOption)
            : $this->error('更新失败');
    }

    /**
     * @title 查看设置详情
     *
     * @param SettingOption $settingOption
     *
     * @return JsonResponse
     */
    public function show(SettingOption $settingOption): JsonResponse
    {
        return $this->success('获取设置详情成功', $settingOption);
    }

    /**
     * @title 删除设置
     *
     * @param SettingOption $settingOption
     *
     * @return JsonResponse
     */
    public function destroy(SettingOption $settingOption): JsonResponse
    {
        return $settingOption->delete()
            ? $this->success('删除成功', $settingOption)
            : $this->error('删除失败');
    }
}
