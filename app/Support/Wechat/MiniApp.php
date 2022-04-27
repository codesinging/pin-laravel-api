<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Wechat;

use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\MiniApp\Application;
use ReflectionException;
use Throwable;

class MiniApp
{
    /**
     * @throws InvalidArgumentException
     */
    public static function app(): Application
    {
        return new Application(config('wechat.mini_app'));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public static function server(): \EasyWeChat\MiniApp\Server|\EasyWeChat\Kernel\Contracts\Server
    {
        return self::app()->getServer();
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function client(): \EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient
    {
        return self::app()->getClient();
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function config(string $key = null, mixed $default = null)
    {
        return is_null($key) ? self::app()->getConfig() : self::app()->getConfig()->get($key, $default);
    }
}
