<?php

namespace Database\Seeders;

use App\Models\AdminMenu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    private array $menus = [
        ['name' => '首页', 'path' => 'home', 'icon' => 'bi-house', 'default' => true, 'sort' => 1],
        ['name' => '系统管理', 'path' => 'system', 'icon' => 'bi-gear', 'opened' => true, 'sort' => 2, 'children' => [
            ['name' => '管理员管理', 'path' => 'admins', 'icon' => 'bi-person', 'sort' => 2],
            ['name' => '菜单管理', 'path' => 'menus', 'icon' => 'bi-list', 'sort' =>1],
            ['name' => '权限管理', 'path' => 'authorizations', 'icon' => 'bi-locker', 'sort' => 3, 'children' => [
                ['name' => '角色管理', 'path' => 'roles'],
                ['name' => '权限管理', 'path' => 'auths'],
            ]],
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