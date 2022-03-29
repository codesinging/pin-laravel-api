<?php

namespace App\Models;

use App\Events\AdminPageDeleted;
use App\Events\AdminPageCreated;
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
        'created' => AdminPageCreated::class,
        'deleted' => AdminPageDeleted::class,
    ];
}
