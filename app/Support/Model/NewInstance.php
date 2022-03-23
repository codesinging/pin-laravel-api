<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use JetBrains\PhpStorm\Pure;

trait NewInstance
{
    /**
     * 返回一个模型实例
     *
     * @param array $attributes
     *
     * @return static
     */
    #[Pure]
    public static function new(array $attributes = []): static
    {
        return new static($attributes);
    }
}
