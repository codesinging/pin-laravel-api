<?php

namespace Database\Seeders;

use App\Models\AdminPage;
use App\Models\AdminRoute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            AdminPageSeeder::class,
            AdminMenuSeeder::class,
            AdminRouteSeeder::class,
            AdminAuthPermissionSeeder::class,
        ]);
    }
}
