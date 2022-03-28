<?php

namespace App\Events;

use App\Models\AdminAuthPermission;
use App\Models\AdminPage;

class AdminPageDeleted
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminPage $adminPage)
    {
        AdminAuthPermission::deleteFrom($adminPage);
    }
}
