<?php

namespace App\Models;

use App\Events\AdminPageDeleted;
use App\Events\AdminPageSaved;
use App\Support\Model\BaseModel;

class AdminPage extends BaseModel
{
    protected $fillable = [
        'name',
        'path',
        'sort',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $dispatchesEvents = [
        'saved' => AdminPageSaved::class,
        'deleted' => AdminPageDeleted::class,
    ];
}
