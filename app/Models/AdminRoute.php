<?php

namespace App\Models;

use App\Events\AdminRouteDeleted;
use App\Events\AdminRouteCreated;
use App\Support\Model\BaseModel;

class AdminRoute extends BaseModel
{
    protected $fillable = [
        'controller',
        'action',
        'controller_title',
        'action_title',
    ];

    protected $dispatchesEvents = [
        'created' => AdminRouteCreated::class,
        'deleted' => AdminRouteDeleted::class,
    ];
}
