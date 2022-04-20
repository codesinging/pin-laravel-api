<?php

namespace App\Events;

use App\Models\AdminPermission;
use App\Models\AdminPage;

class AdminPageCreated
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminPage $adminPage)
    {
        AdminPermission::createFrom($adminPage);
    }
}
