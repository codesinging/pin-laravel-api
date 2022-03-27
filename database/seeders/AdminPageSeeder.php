<?php

namespace Database\Seeders;

use App\Models\AdminPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminPageSeeder extends Seeder
{
    protected array $pages = [
        ['name' => '仪表盘', 'path' => 'dashboard'],
        ['name' => '后台菜单管理', 'path' => 'admin_menus'],
        ['name' => '后台页面管理', 'path' => 'admin_pages'],
        ['name' => '后台管理员管理', 'path' => 'admins'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->pages as $page) {
            AdminPage::new()->create($page);
        }
    }
}
