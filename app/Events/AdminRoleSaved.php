<?php

namespace App\Events;

use App\Models\AdminAuthRole;
use App\Models\AdminRole;

class AdminRoleSaved
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminRole $adminRole)
    {
        AdminAuthRole::syncFrom($adminRole);
    }
}
