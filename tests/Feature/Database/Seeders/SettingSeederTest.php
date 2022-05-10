<?php

namespace Tests\Feature\Database\Seeders;

use App\Models\Setting;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeed()
    {
        $this->seed(SettingSeeder::class);

        $setting = Setting::new()->inRandomOrder()->first();

        $this->assertModelExists($setting);
        $this->assertDatabaseCount(Setting::class, 3);
    }
}
