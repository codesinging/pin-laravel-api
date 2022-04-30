<?php

namespace App\Models;

use App\Support\Model\BaseModel;

class SettingOption extends BaseModel
{
    protected $fillable = [
        'group_id',
        'name',
        'type',
        'default',
        'attributes',
        'options',
        'sort',
        'status',
    ];

    protected $casts = [
        'default' => 'json',
        'attributes' => 'json',
        'options' => 'json',
        'status' => 'boolean',
    ];
}
