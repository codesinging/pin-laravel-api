<?php

namespace App\Events;

use App\Models\AdminAuthPermission;
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
        AdminAuthPermission::createFrom($adminMenu);
    }
}
