<?php

namespace App\Models;

use App\Events\AdminRouteDeleted;
use App\Events\AdminRouteCreated;
use App\Support\Model\AuthPermissionContract;
use App\Support\Model\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminRoute extends BaseModel implements AuthPermissionContract
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

    protected $with = [
        'permission',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(AdminAuthPermission::class, 'permission_id');
    }
}
