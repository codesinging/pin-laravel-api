<?php

namespace App\Models;

use App\Events\AdminMenuDeleted;
use App\Events\AdminMenuCreated;
use App\Support\Model\AuthPermissionContract;
use App\Support\Model\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kalnoy\Nestedset\NodeTrait;

class AdminMenu extends BaseModel implements AuthPermissionContract
{
    use NodeTrait;

    protected $fillable = [
        'name',
        'path',
        'url',
        'icon',
        'sort',
        'default',
        'opened',
        'status',
    ];

    protected $casts = [
        'default' => 'boolean',
        'opened' => 'boolean',
        'status' => 'boolean',
    ];

    protected $dispatchesEvents = [
        'created' => AdminMenuCreated::class,
        'deleted' => AdminMenuDeleted::class,
    ];

    protected $with = [
        'permission',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(AdminAuthPermission::class, 'permission_id');
    }
}
