<?php

namespace Database\Seeders;

use App\Models\AdminMenu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    private array $menus = [
        ['name' => '首页', 'path' => 'home', 'icon' => 'bi-house', 'default' => true, 'sort' => 9],
        ['name' => '系统管理', 'path' => 'system', 'icon' => 'bi-command', 'opened' => true, 'sort' => 3, 'children' => [
            ['name' => '角色管理', 'path' => 'roles', 'icon' => 'bi-people', 'sort' => 99],
            ['name' => '管理员管理', 'path' => 'admins', 'icon' => 'bi-person', 'sort' => 98],
            ['name' => '菜单管理', 'path' => 'menus', 'icon' => 'bi-list', 'sort' => 97],
            ['name' => '页面管理', 'path' => 'pages', 'icon' => 'bi-file-earmark-text', 'sort' => 96],
            ['name' => '路由管理', 'path' => 'routes', 'icon' => 'bi-shield-check', 'sort' => 95],
            ['name' => '网站设置', 'path' => 'settings', 'icon' => 'bi-gear', 'sort' => 89],
            ['name' => '设置分组管理', 'path' => 'setting_groups', 'icon' => 'bi-gear-fill', 'sort' => 88],
            ['name' => '设置选项管理', 'path' => 'setting_options', 'icon' => 'bi-gear-wide', 'sort' => 87],
        ]],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->menus as $menu) {
            AdminMenu::create($menu);
        }
    }
}
