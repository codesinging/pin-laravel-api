<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Feature\Models;

use App\Models\SettingOption;
use Database\Seeders\SettingGroupSeeder;
use Database\Seeders\SettingOptionSeeder;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingOptionTest extends TestCase
{
    use RefreshDatabase;

    public function testSetting()
    {
        $this->seed(SettingSeeder::class);
        $this->seed(SettingGroupSeeder::class);
        $this->seed(SettingOptionSeeder::class);

        $option = SettingOption::one();

        self::assertEquals($option['group_id'], $option['group']['id']);
    }
}
