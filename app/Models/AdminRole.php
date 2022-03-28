<?php

namespace App\Models;

use App\Events\AdminRoleDeleted;
use App\Events\AdminRoleSaved;
use App\Support\Model\BaseModel;
use Spatie\Permission\Contracts\Role;

class AdminRole extends BaseModel
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
        'saved' => AdminRoleSaved::class,
        'deleted' => AdminRoleDeleted::class,
    ];

    /**
     * @return Role|\Spatie\Permission\Models\Role
     */
    public function authRole(): Role|\Spatie\Permission\Models\Role
    {
        return AdminAuthRole::findFrom($this);
    }
}
