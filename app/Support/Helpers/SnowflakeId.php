<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Helpers;

use Kra8\Snowflake\Snowflake;

class SnowflakeId
{
    /**
     * @return Snowflake
     */
    public static function instance(): Snowflake
    {
        return app(Snowflake::class);
    }

    /**
     * 生成 64 位唯一ID
     * @return int
     */
    public static function id(): int
    {
        return self::instance()->id();
    }

    /**
     * 生成 53 位唯一ID，适用 JS 处理
     * @return int
     */
    public static function shortId(): int
    {
        return self::instance()->short();
    }
}
