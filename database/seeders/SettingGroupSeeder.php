<?php

namespace Database\Seeders;

use App\Models\SettingGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingGroupSeeder extends Seeder
{
    protected array $groups = [
        ['name' => '网站设置','description' => '关于网站的总体设置'],
        ['name' => '用户设置', 'description' => '关于用户方面的设置'],
        ['name' => '上传设置', 'description' => '关于文件上传方面的设置'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->groups as $group) {
            SettingGroup::creates($group);
        }
    }
}
