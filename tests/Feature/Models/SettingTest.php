<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Feature\Models;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function testCasts()
    {
        Setting::new()->create([
            'key' => 'string',
            'value' => 'stringValue',
        ]);
        Setting::new()->create([
            'key' => 'boolean',
            'value' => false,
        ]);
        Setting::new()->create([
            'key' => 'array',
            'value' => ['a','b','c'],
        ]);


        self::assertEquals('stringValue', Setting::new()->where('key', 'string')->first()['value']);
        self::assertSame(false, Setting::new()->where('key', 'boolean')->first()['value']);
        self::assertEquals(['a','b','c'], Setting::new()->where('key', 'array')->first()['value']);
    }
}
