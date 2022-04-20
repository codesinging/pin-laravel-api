<?php

namespace App\Events;

use App\Models\AdminPermission;
use App\Models\AdminMenu;

class AdminMenuCreated
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminMenu $adminMenu)
    {
        AdminPermission::createFrom($adminMenu);
    }
}
