<?php

namespace App\Events;

use App\Models\AdminAuthPermission;
use App\Models\AdminPage;

class AdminPageSaved
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AdminPage $adminPage)
    {
        AdminAuthPermission::syncFrom($adminPage);
    }
}
