<?php

namespace App\Models;

use App\Support\Model\HelperTraits;
use Spatie\Permission\Models\Role;

/**
 * @property Role $role
 */
class AdminRole extends Role
{
    use HelperTraits;

    protected string $guard_name = 'sanctum';

    protected $fillable = [
        'name',
        'guard_name',
        'description',
        'sort',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
