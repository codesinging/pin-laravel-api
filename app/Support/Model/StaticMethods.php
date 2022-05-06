<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait StaticMethods
{
    /**
     * 创建模型
     * @param array $attributes
     *
     * @return Model|BaseModel|$this
     */
    public static function creates(array $attributes = []): Model|BaseModel|static
    {
        return (new static())->create($attributes);
    }

    /**
     * 查找一个模型
     * @param array|string $columns
     *
     * @return Model|$this|null
     */
    public static function one(array|string $columns = ['*']): Model|null|static
    {
        return (new static())->first($columns);
    }

    /**
     * 查找指定的模型
     * @param $id
     * @param string[] $columns
     *
     * @return Model|Collection|$this|null
     */
    public static function finds($id, array $columns = ['*']): Model|Collection|null|static
    {
        return (new static())->find($id, $columns);
    }

}
