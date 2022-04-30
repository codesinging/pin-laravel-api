<?php

namespace Tests\Feature\Database\Seeders;

use App\Models\SettingOption;
use Database\Seeders\SettingOptionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingOptionSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeed()
    {
        $this->seed(SettingOptionSeeder::class);

        $this->assertDatabaseHas(SettingOption::class, ['id' => 1]);
    }
}
