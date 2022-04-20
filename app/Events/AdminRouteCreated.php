<?php

namespace App\Events;

use App\Models\AdminPermission;
use App\Models\AdminRoute;

class AdminRouteCreated
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminRoute $adminRoute)
    {
        AdminPermission::createFrom($adminRoute);
    }
}
