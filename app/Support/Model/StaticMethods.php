<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use Illuminate\Database\Eloquent\Model;

trait StaticMethods
{
    public static function creates(array $attributes = []): Model|BaseModel
    {
        return (new static())->create($attributes);
    }

    public static function one(array|string $columns = ['*']): Model|BaseModel|null
    {
        return (new static())->first($columns);
    }

    public static function finds($id, $columns = ['*'])
    {
        return (new static())->find($id, $columns);
    }
}
