<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

trait UniqueRule
{
    /**
     * 返回唯一性验证的规则
     *
     * @return Unique
     */
    public function uniqueRule(): Unique
    {
        return Rule::unique($this->getTable())->ignore($this);
    }
}
