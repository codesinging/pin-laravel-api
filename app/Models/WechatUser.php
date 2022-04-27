<?php

namespace App\Models;

use App\Support\Model\AuthModel;

class WechatUser extends AuthModel
{
    protected $fillable = [
        'openid',
        'name',
        'mobile',
        'avatar',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
