<?php

namespace App\Models;

use App\Events\AdminRoleDeleted;
use App\Events\AdminRoleSaved;
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

    protected $dispatchesEvents = [
        'saved' => AdminRoleSaved::class,
        'deleted' => AdminRoleDeleted::class,
    ];
}
