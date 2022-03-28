<?php

namespace App\Models;

use App\Events\AdminRouteDeleted;
use App\Events\AdminRouteSaved;
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
        'saved' => AdminRouteSaved::class,
        'deleted' => AdminRouteDeleted::class,
    ];
}
