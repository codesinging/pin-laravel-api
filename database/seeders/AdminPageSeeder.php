<?php

namespace Database\Seeders;

use App\Models\AdminPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminPageSeeder extends Seeder
{
    protected array $pages = [
        ['name' => '首页', 'path' => 'home'],
        ['name' => '菜单管理', 'path' => 'menus'],
        ['name' => '页面管理', 'path' => 'pages'],
        ['name' => '角色管理', 'path' => 'roles'],
        ['name' => '路由管理', 'path' => 'routes'],
        ['name' => '管理员管理', 'path' => 'admins'],
        ['name' => '系统设置', 'path' => 'settings'],
        ['name' => '系统设置分组管理', 'path' => 'setting_groups'],
        ['name' => '系统设置管理', 'path' => 'setting_options'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->pages as $page) {
            AdminPage::new()->create($page);
        }
    }
}
