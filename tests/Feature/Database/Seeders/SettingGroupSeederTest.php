<?php

namespace Tests\Feature\Database\Seeders;

use App\Models\SettingGroup;
use Database\Seeders\SettingGroupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingGroupSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeed()
    {
        $this->seed(SettingGroupSeeder::class);

        $this->assertDatabaseHas(SettingGroup::class, ['id' => 1]);
    }
}
