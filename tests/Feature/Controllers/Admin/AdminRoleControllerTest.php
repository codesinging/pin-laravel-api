<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\AdminRole;
use Database\Seeders\AdminRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AdminActing;
use Tests\TestCase;

class AdminRoleControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function testIndex()
    {
        $this->seed(AdminRoleSeeder::class);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/admin_roles')
            ->assertJsonPath('code', 0)
            ->assertOk();
    }

    public function testStore()
    {
        $this->seedAdmin()
            ->actingAsAdmin()
            ->postJson('api/admin/admin_roles', ['name' => '系统管理员'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', '系统管理员');

        $this->actingAsAdmin()
            ->postJson('api/admin/admin_roles')
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    public function testUpdate()
    {
        $data1 = ['name' => 'Name'];
        $data2 = ['name' => 'Name2'];

        $role1 = AdminRole::new()->create($data1);
        $role2 = AdminRole::new()->create($data2);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->putJson('api/admin/admin_roles/' . $role1['id'], ['name' => 'Name'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'Name');

        $this->actingAsAdmin()
            ->putJson('api/admin/admin_roles/' . $role1['id'], ['name' => 'Name2'])
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    public function testShow()
    {
        $data = ['name' => 'Name', 'path' => 'path'];

        $role = AdminRole::new()->create($data);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->getJson('api/admin/admin_roles/' . $role['id'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'Name');
    }

    public function testDestroy()
    {
        $data = ['name' => 'Name', 'path' => 'path'];

        $role = AdminRole::new()->create($data);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->deleteJson('api/admin/admin_roles/' . $role['id'])
            ->assertOk()
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'Name');

        $this->assertDatabaseMissing('admin_roles', [
            'id' => $role['id'],
        ]);
    }
}
