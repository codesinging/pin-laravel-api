<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Routing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait ValidateUnique
{
    /**
     * @param string|array $columns
     * @param Request|FormRequest $request
     * @param Model $model
     * @param array|null $messages
     * @param array|null $attributes
     *
     * @return void
     */
    public function validateUnique(string|array $columns, Request|FormRequest $request, Model $model, array $messages = null, array $attributes = null): void
    {
        $rules = [];

        $unique = $model[$model->getKeyName()]
            ? Rule::unique($model->getTable())->ignore($model)
            : 'unique:' . $model->getTable();

        foreach ((array)$columns as $column) {
            $rules[$column] = $unique;
        }

        $messages = $messages ?: (method_exists($request, 'messages') ? $request->messages() : []);
        $attributes = $attributes ?: (method_exists($request, 'attributes') ? $request->$attributes() : []);

        $request->validate($rules, $messages, $attributes);
    }
}
