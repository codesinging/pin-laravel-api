<?php

namespace Database\Seeders;

use App\Models\AdminRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminRoleSeeder extends Seeder
{
    protected array $roles = [
        ['name' => '系统管理员', 'description' => '具有系统管理权限'],
        ['name' => '内容管理员', 'description' => '具有内容管理权限'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $role) {
            AdminRole::new()->create($role);
        }
    }
}
