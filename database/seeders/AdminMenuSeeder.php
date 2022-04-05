<?php

namespace Database\Seeders;

use App\Models\AdminMenu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    private array $menus = [
        ['name' => '首页', 'path' => 'home', 'icon' => 'bi-house', 'default' => true, 'sort' => 1],
        ['name' => '系统管理', 'path' => 'system', 'icon' => 'bi-gear', 'opened' => true, 'sort' => 2, 'children' => [
            ['name' => '菜单管理', 'path' => 'menus', 'icon' => 'bi-list', 'sort' => 1],
            ['name' => '管理员管理', 'path' => 'admins', 'icon' => 'bi-person', 'sort' => 2],
            ['name' => '角色管理', 'path' => 'roles', 'icon' => 'bi-people', 'sort' => 3],
            ['name' => '页面管理', 'path' => 'pages', 'icon' => 'bi-file-earmark-text', 'sort' => 4],
            ['name' => '路由管理', 'path' => 'routes', 'icon' => 'bi-shield-check', 'sort' => 4],
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
