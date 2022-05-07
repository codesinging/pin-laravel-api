<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests;

use App\Models\WechatUser;
use Database\Seeders\WechatUserSeeder;

trait WechatUserActing
{
    /**
     * 获取一个微信用户
     *
     * @param string|int|array|null $user
     *
     * @return WechatUser|null
     */
    protected function getWechatUser(string|int|array $user = null): ?WechatUser
    {
        if (is_int($user)) {
            return WechatUser::new()->find($user);
        } elseif (is_string($user)) {
            return WechatUser::new()->where('openid', $user)->first();
        } elseif (is_array($user)) {
            return WechatUser::new()->where($user)->first();
        } else {
            return WechatUser::new()->first();
        }
    }

    /**
     * 以微信用户身份登录
     *
     * @param string|int|array|WechatUser|null $user
     *
     * @return $this
     */
    protected function actingAsWechatUser(string|int|array|WechatUser $user = null): static
    {
        $user instanceof WechatUser or $user = $this->getWechatUser($user);
        $this->actingAs($user);
        return $this;
    }

    /**
     * 填充微信用户数据
     *
     * @return $this
     */
    protected function seedWechatUser(): static
    {
        if (!property_exists($this, 'seed') || $this->seed === false) {
            $this->seed(WechatUserSeeder::class);
        }

        return $this;
    }
}
