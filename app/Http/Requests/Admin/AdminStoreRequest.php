<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:admins',
            'name' => 'required|unique:admins',
            'password' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '管理员名称',
            'username' => '登录账号',
            'password' => '登录密码',
        ];
    }
}
