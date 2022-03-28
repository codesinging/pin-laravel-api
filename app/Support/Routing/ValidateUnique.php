<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Routing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait ValidateUnique
{
    /**
     * 检查字段唯一性
     *
     * @param Request $request
     * @param Model $model
     * @param string|array $columns
     * @param array $messages
     * @param array $attributes
     *
     * @return array
     */
    public function validateUnique(Request $request, Model $model, string|array $columns, array $messages = [], array $attributes = []): array
    {
        $uniqueRule = is_null($id = $model['id'])
            ? ('unique:' . $model->getTable())
            : Rule::unique($model->getTable())->ignore($id);

        $rules = [];

        foreach ((array)$columns as $column) {
            $rules[$column] = $uniqueRule;
        }

        $attributes = $attributes ?: (method_exists($request, 'attributes') ? $request->attributes() : []);

        return $request->validate($rules, $messages, $attributes);
    }
}
