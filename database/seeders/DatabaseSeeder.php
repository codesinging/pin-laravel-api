<?php

namespace Database\Seeders;

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
            AdminRoleSeeder::class,

            PersonalAccessTokenSeeder::class,
        ]);
    }
}
