<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    protected array $settings = [
        ['key' => 'site_name', 'value' => '品凡网络科技'],
        ['key' => 'site_description', 'value' => '网络软件开发运营托管等'],
        ['key' => 'site_status', 'value' => true],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $setting) {
            Setting::creates($setting);
        }
    }
}
