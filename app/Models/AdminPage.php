<?php

namespace App\Models;

use App\Events\AdminPageDeleted;
use App\Events\AdminPageCreated;
use App\Support\Model\PermissionContract;
use App\Support\Model\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminPage extends BaseModel implements PermissionContract
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

    protected $with = [
        'permission',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(AdminPermission::class, 'permission_id');
    }
}
