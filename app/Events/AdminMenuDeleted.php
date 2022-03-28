<?php

namespace App\Events;

use App\Models\AdminAuthPermission;
use App\Models\AdminMenu;

class AdminMenuDeleted
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminMenu $adminMenu)
    {
        AdminAuthPermission::deleteFrom($adminMenu);
    }
}
