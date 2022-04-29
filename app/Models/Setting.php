<?php

namespace App\Models;

use App\Support\Model\BaseModel;

class Setting extends BaseModel
{
    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'json',
    ];
}
