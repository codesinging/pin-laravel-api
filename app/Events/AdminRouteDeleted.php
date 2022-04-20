<?php

namespace App\Events;

use App\Models\AdminPermission;
use App\Models\AdminRoute;

class AdminRouteDeleted
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminRoute $adminRoute)
    {
        AdminPermission::deleteFrom($adminRoute);
    }
}
