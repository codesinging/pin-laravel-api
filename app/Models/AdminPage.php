<?php

namespace App\Models;

use App\Events\AdminPageDeleted;
use App\Events\AdminPageCreated;
use App\Support\Model\AuthPermissionContract;
use App\Support\Model\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminPage extends BaseModel implements AuthPermissionContract
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
        return $this->belongsTo(AdminAuthPermission::class, 'permission_id');
    }
}
