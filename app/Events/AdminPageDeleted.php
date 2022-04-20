<?php

namespace App\Events;

use App\Models\AdminPermission;
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
        AdminPermission::deleteFrom($adminPage);
    }
}
