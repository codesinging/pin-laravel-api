<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Wechat;

use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Pay\Application;
use EasyWeChat\Pay\Utils;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Pay
{
    /**
     * @throws InvalidArgumentException
     */
    public static function app(): Application
    {
        return new Application(config('wechat.pay'));
    }

    /**
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    public static function client(): HttpClientInterface
    {
        return self::app()->getClient();
    }

    /**
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    public static function utils(): Utils
    {
        return self::app()->getUtils();
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function config(string $key = null, mixed $default = null)
    {
        return is_null($key) ? self::app()->getConfig() : self::app()->getConfig()->get($key, $default);
    }
}
