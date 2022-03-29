<?php

namespace App\Models;

use App\Events\AdminRoleDeleted;
use App\Events\AdminRoleCreated;
use App\Support\Model\AuthRoleContract;
use App\Support\Model\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Contracts\Role;

class AdminRole extends BaseModel implements AuthRoleContract
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
        'created' => AdminRoleCreated::class,
        'deleted' => AdminRoleDeleted::class,
    ];

    protected $with = [
        'role',
    ];

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(AdminAuthRole::class, 'role_id');
    }

    /**
     * @return Role|\Spatie\Permission\Models\Role
     */
    public function authRole(): Role|\Spatie\Permission\Models\Role
    {
        return AdminAuthRole::findFrom($this);
    }
}
