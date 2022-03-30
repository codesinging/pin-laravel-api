<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Sanctum\PersonalAccessToken;

class PersonalAccessTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1|Z0XP7ZkkmEnrkoH1UwgdAjxLxMT6v3oE411QrD4w
        PersonalAccessToken::query()->create([
            'tokenable_type' => 'App\Models\Admin',
            'tokenable_id' => 1,
            'name' => '',
            'token' => '54383c5f4dfc610dab0d13cf8cd4839136bfbaccdc611770349d2d30dd0ea0ea',
            'abilities' => ["*"]
        ]);
    }
}
