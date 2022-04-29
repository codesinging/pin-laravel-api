<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\SettingGroup;
use Database\Seeders\SettingGroupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\AdminActing;
use Tests\TestCase;

class SettingGroupControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function testIndex()
    {
        $this->seed(SettingGroupSeeder::class);
        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/setting_groups')
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('code', 0)
            ->assertOk();
    }

    public function testStore()
    {
        $this->seedAdmin()
            ->actingAsAdmin()
            ->postJson('api/admin/setting_groups', ['name' => 'testGroup'])
            ->assertJsonPath('data.name', 'testGroup')
            ->assertJsonPath('code', 0)
            ->assertOk();

        $this->actingAsAdmin()
            ->postJson('api/admin/setting_groups')
            ->assertStatus(422);
    }

    public function testUpdate()
    {
        $data1 = ['name' => 'Name1'];
        $data2 = ['name' => 'Name2'];

        $newData = ['name' => 'newName'];

        $model1 = SettingGroup::creates($data1);
        $model2 = SettingGroup::creates($data2);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->putJson('api/admin/setting_groups/' . $model1['id'], $newData)
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $model1['id'])
            ->assertJsonPath('data.name', $newData['name']);

        $this->actingAsAdmin()
            ->putJson('api/admin/setting_groups/' . $model1['id'], $data2)
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    public function testShow()
    {
        $data = ['name' => 'Name'];

        $model = SettingGroup::creates($data);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/setting_groups/' . $model['id'])
            ->assertJsonPath('data.name', $data['name'])
            ->assertOk()
            ->assertJsonPath('code', 0);
    }

    public function testDestroy()
    {
        $data = ['name' => 'Name'];

        $model = SettingGroup::creates($data);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->deleteJson('api/admin/setting_groups/'. $model['id'])
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $model['id'])
            ->assertOk();

        $this->assertModelMissing($model);
    }
}
