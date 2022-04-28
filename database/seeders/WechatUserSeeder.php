<?php

namespace Database\Seeders;

use App\Models\WechatUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WechatUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        WechatUser::factory()->count(50)->create();
    }
}
