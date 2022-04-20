<?php

namespace App\Models;

use App\Events\AdminMenuDeleted;
use App\Events\AdminMenuCreated;
use App\Support\Model\PermissionContract;
use App\Support\Model\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kalnoy\Nestedset\NodeTrait;

class AdminMenu extends BaseModel implements PermissionContract
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
        return $this->belongsTo(AdminPermission::class, 'permission_id');
    }
}
