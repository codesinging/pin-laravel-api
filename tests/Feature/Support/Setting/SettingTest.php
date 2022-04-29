<?php

namespace Tests\Feature\Support\Setting;

use App\Models\Setting as SettingModel;
use App\Support\Setting\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function testHas()
    {
        SettingModel::new()->create(['key' => 'name', 'value' => 'zhang']);

        self::assertTrue(Setting::has('name'));
        self::assertFalse(Setting::has('age'));
    }

    public function testGet()
    {
        SettingModel::new()->create(['key' => 'name', 'value' => 'zhang']);
        SettingModel::new()->create(['key' => 'age', 'value' => 32]);
        SettingModel::new()->create(['key' => 'favorites', 'value' => ['reading', 'playing']]);

        self::assertEquals('zhang', Setting::get('name'));
        self::assertEquals('zhang2', Setting::get('name2', 'zhang2'));
        self::assertEquals(['reading', 'playing'], Setting::get('favorites'));

        self::assertEquals(['name' =>'zhang'], Setting::get(['name']));
        self::assertEquals(['name' =>'zhang', 'age' => 32], Setting::get(['name', 'age']));
        self::assertEquals(['name' =>'zhang', 'favorites' => ['reading', 'playing']], Setting::get(['name', 'favorites']));
    }

    public function testSet()
    {
        Setting::set('name', 'zhang');

        Setting::set(['age' => 32, 'favorites' => ['reading', 'playing']]);

        self::assertEquals('zhang', Setting::get('name'));
        self::assertEquals(32, Setting::get('age'));
        self::assertEquals(['reading', 'playing'], Setting::get('favorites'));
        $this->assertDatabaseHas(SettingModel::class, ['key' =>'name']);
        $this->assertDatabaseHas(SettingModel::class, ['key' =>'age']);
        $this->assertDatabaseHas(SettingModel::class, ['key' =>'favorites']);
    }

    public function testRemove()
    {
        SettingModel::new()->create(['key' => 'name', 'value' => 'zhang']);
        SettingModel::new()->create(['key' => 'age', 'value' => 32]);
        SettingModel::new()->create(['key' => 'sex', 'value' => 'male']);

        $this->assertDatabaseHas(SettingModel::class, ['key' => 'name']);
        $this->assertDatabaseHas(SettingModel::class, ['key' => 'age']);
        $this->assertDatabaseHas(SettingModel::class, ['key' => 'sex']);

        Setting::remove('name');
        Setting::remove(['age', 'sex']);

        $this->assertDatabaseMissing(SettingModel::class, ['key' => 'name']);
        $this->assertDatabaseMissing(SettingModel::class, ['key' => 'age']);
        $this->assertDatabaseMissing(SettingModel::class, ['key' => 'sex']);
    }
}
