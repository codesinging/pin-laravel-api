<?php

namespace App\Models;

use App\Support\Model\BaseModel;

class AdminRole extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'sort',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
