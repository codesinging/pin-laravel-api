<?php

namespace App\Models;

use App\Support\Model\BaseModel;

class AdminRoute extends BaseModel
{
    protected $fillable = [
        'controller',
        'action',
        'controller_title',
        'action_title',
    ];
}
