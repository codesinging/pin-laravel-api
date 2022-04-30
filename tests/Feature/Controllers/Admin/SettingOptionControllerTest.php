<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\SettingOption;
use Database\Seeders\SettingOptionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\AdminActing;
use Tests\TestCase;

class SettingOptionControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function testIndex()
    {
        $this->seed(SettingOptionSeeder::class);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/setting_options')
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('code', 0)
            ->assertOk();
    }

    public function testStore()
    {
        $this->seedAdmin()
            ->actingAsAdmin()
            ->postJson('api/admin/setting_options', ['group_id' => 1, 'name' => 'test'])
            ->assertJsonPath('data.name', 'test')
            ->assertJsonPath('code', 0)
            ->assertOk();

        $this->actingAsAdmin()
            ->postJson('api/admin/setting_options')
            ->assertStatus(422);
    }

    public function testUpdate()
    {
        $data1 = ['group_id' => 1, 'name' => 'Name1'];
        $data2 = ['group_id' => 1, 'name' => 'Name2'];

        $newData = ['group_id' => 1, 'name' => 'newName'];

        $model1 = SettingOption::creates($data1);
        $model2 = SettingOption::creates($data2);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->putJson('api/admin/setting_options/' . $model1['id'], $newData)
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $model1['id'])
            ->assertJsonPath('data.name', $newData['name']);

        $this->actingAsAdmin()
            ->putJson('api/admin/setting_options/' . $model1['id'], $data2)
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    public function testShow()
    {
        $data = ['group_id' => 1, 'name' => 'Name'];

        $model = SettingOption::creates($data);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/setting_options/' . $model['id'])
            ->assertJsonPath('data.name', $data['name'])
            ->assertOk()
            ->assertJsonPath('code', 0);
    }

    public function testDestroy()
    {
        $data = ['group_id' => 1, 'name' => 'Name'];

        $model = SettingOption::creates($data);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->deleteJson('api/admin/setting_options/' . $model['id'])
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $model['id'])
            ->assertOk();

        $this->assertModelMissing($model);
    }
}
