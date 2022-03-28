<?php

namespace App\Events;

use App\Models\AdminAuthPermission;
use App\Models\AdminRoute;

class AdminRouteSaved
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminRoute $adminRoute)
    {
        AdminAuthPermission::syncFrom($adminRoute);
    }
}
