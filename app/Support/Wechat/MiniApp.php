<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Wechat;

use EasyWeChat\Kernel\Contracts\Server;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;
use EasyWeChat\MiniApp\Application;
use EasyWeChat\MiniApp\Contracts\Account;
use EasyWeChat\MiniApp\Utils;
use ReflectionException;
use Throwable;

class MiniApp
{
    /**
     * @throws InvalidArgumentException
     */
    public static function app(): Application
    {
        return new Application(config('wechat.mini'));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     * @throws Throwable
     */
    public static function server(): \EasyWeChat\MiniApp\Server|Server
    {
        return self::app()->getServer();
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function client(): AccessTokenAwareClient
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

    /**
     * @throws InvalidArgumentException
     */
    public static function accessToken(): string
    {
        return self::app()->getAccessToken()->getToken();
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function account(): Account
    {
        return self::app()->getAccount();
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function utils(): Utils
    {
        return self::app()->getUtils();
    }
}
