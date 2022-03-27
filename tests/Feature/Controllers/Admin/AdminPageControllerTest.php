<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\AdminPage;
use Database\Seeders\AdminPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AdminActing;
use Tests\TestCase;

class AdminPageControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function test_index()
    {
        $this->seed(AdminPageSeeder::class);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/admin_pages')
            ->assertJsonPath('code', 0)
            ->assertOk();
    }

    public function test_store()
    {
        $this->seedAdmin()
            ->actingAsAdmin()
            ->postJson('api/admin/admin_pages', ['name' => 'Name', 'path' => 'path'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'Name');

        $this->actingAsAdmin()
            ->postJson('api/admin/admin_pages', ['name' => 'Name', 'path' => 'path'])
            ->assertJsonStructure(['message', 'errors' => ['path']])
            ->assertStatus(422);
    }

    public function test_update()
    {
        $data1 = ['name' => 'Name', 'path' => 'path'];
        $data2 = ['name' => 'Name2', 'path' => 'path2'];

        $page1 = AdminPage::new()->create($data1);
        $page2 = AdminPage::new()->create($data2);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->putJson('api/admin/admin_pages/' . $page1['id'], ['name' => 'NewName', 'path' => 'new_path'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'NewName');

        $this->actingAsAdmin()
            ->putJson('api/admin/admin_pages/' . $page1['id'], ['name' => 'NewName2', 'path' => 'new_path'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'NewName2');

        $this->actingAsAdmin()
            ->putJson('api/admin/admin_pages/' . $page1['id'], ['name' => 'NewName2', 'path' => 'path2'])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['path']]);
    }

    public function test_show()
    {
        $data = ['name' => 'Name', 'path' => 'path'];

        $page = AdminPage::new()->create($data);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/admin_pages/' . $page['id'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'Name');
    }

    public function test_destroy()
    {
        $data = ['name' => 'Name', 'path' => 'path'];

        $page = AdminPage::new()->create($data);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->deleteJson('api/admin/admin_pages/' . $page['id'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'Name');
    }
}
