<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\ErrorCode;
use App\Models\Admin;
use App\Models\AdminMenu;
use App\Models\AdminPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * 管理员登录
     *
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username' => '登录账号不能为空',
            'password' => '登录密码不能为空'
        ]);

        /** @var Admin $admin */
        $admin = Admin::new()->where('username', $request->get('username'))->first();

        if (!$admin) {
            return $this->error('账号不存在', ErrorCode::AUTH_USER_NOT_EXISTED);
        }

        if (!Hash::check($request->get('password'), $admin['password'])) {
            return $this->error('账号与密码不匹配', ErrorCode::AUTH_PASSWORD_NOT_MATCHED);
        }

        if (!$admin['status']) {
            return $this->error('账号状态异常', ErrorCode::AUTH_USER_STATUS_ERROR);
        }

        $token = $admin->createToken($request->get('device', ''))->plainTextToken;

        return $this->success('登录成功', compact('admin', 'token'));
    }

    /**
     * 注销登录
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var Admin $admin */
        $admin = $request->user();

        $admin->tokens()->where('tokenable_id', $admin['id'])->delete();

        return $this->success('注销成功');
    }

    /**
     * 获取登录用户
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return $this->success('获取认证用户成功', $request->user());
    }

    /**
     * 获取拥有权限的页面列表
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function pages(Request $request): JsonResponse
    {
        /** @var Admin $user */
        $user = $request->user();

        if ($user->isSuper()) {
            $pages = AdminPage::new()->where('status', true)->get();
        } else {
            $pages = AdminPage::new()->where('status', true)->whereIn('permission_id', $user->getPermissionsFrom(AdminPage::class)->pluck('id'))->get();
        }

        return $this->success('获取页面列表成功', $pages);
    }

    /**
     * 获取拥有权限的菜单列表
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function menus(Request $request): JsonResponse
    {
        /** @var Admin $user */
        $user = $request->user();

        if ($user->isSuper()) {
            $menus = AdminMenu::new()->where('status', true)->get();
        } else {
            $menus = AdminMenu::new()->where('status', true)->whereIn('permission_id', $user->getPermissionsFrom(AdminMenu::class)->pluck('id'))->get();
        }

        return $this->success('获取菜单列表成功', $menus);
    }
}
