<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\AdminMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AdminActing;
use Tests\TestCase;

class AuthMenuControllerTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function test_index()
    {
        $menus = [
            ['name' => 'menu1'],
            ['name' => 'menu2'],
            ['name' => 'menu3', 'children' => [
                ['name' => 'menu4'],
                ['name' => 'menu5'],
                ['name' => 'menu6'],
            ]],
        ];

        foreach ($menus as $menu) {
            AdminMenu::create($menu);
        }

        $this->seedAdmin();

        $this->actingAsAdmin()
            ->getJson('api/admin/admin_menus')
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.0.name', 'menu1')
            ->assertJsonPath('data.2.name', 'menu3')
            ->assertJsonPath('data.2.children.0.name', 'menu4')
            ->assertJsonPath('data.2.children.2.name', 'menu6')
            ->assertOk();
    }

    public function test_store_without_parent()
    {
        $this->seedAdmin();

        $this->actingAsAdmin()
            ->postJson('api/admin/admin_menus', ['name' => 'menu_1'])
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'menu_1')
            ->assertJsonPath('data.parent_id', null)
            ->assertOk();
    }

    public function test_store_with_parent()
    {
        $parent = AdminMenu::create(['name' => 'parent_menu']);

        $this->seedAdmin()
            ->actingAsAdmin()
            ->postJson('api/admin/admin_menus', ['name' => 'child_menu', 'parent_id' => $parent['id']])
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.name', 'child_menu')
            ->assertJsonPath('data.parent_id', $parent['id'])
            ->assertOk();
    }

    public function test_update_with_parent_not_changed()
    {
        $menus = [
            ['name' => 'menu1'],
            ['name' => 'menu2'],
            ['name' => 'menu3', 'children' => [
                ['name' => 'menu4'],
                ['name' => 'menu5'],
                ['name' => 'menu6'],
            ]],
        ];

        foreach ($menus as $menu) {
            AdminMenu::create($menu);
        }

        $this->assertDatabaseCount('admin_menus', 6);

        $menu1 = AdminMenu::new()->where('name', 'menu1')->first();
        $menu4 = AdminMenu::new()->where('name', 'menu4')->first();

        $this->seedAdmin();

        $this->actingAsAdmin()
            ->putJson('api/admin/admin_menus/'. $menu1['id'], ['name' => 'menu11'])
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $menu1['id'])
            ->assertJsonPath('data.name', 'menu11')
            ->assertJsonPath('data.parent_id', null)
            ->assertOk();

        $this->actingAsAdmin()
            ->putJson('api/admin/admin_menus/'. $menu4['id'], ['name' => 'menu44', 'parent_id' => $menu4['parent_id']])
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $menu4['id'])
            ->assertJsonPath('data.name', 'menu44')
            ->assertJsonPath('data.parent_id', $menu4['parent_id'])
            ->assertOk();
    }

    public function test_update_with_parent_changed()
    {
        $menus = [
            ['name' => 'menu1'],
            ['name' => 'menu2'],
            ['name' => 'menu3', 'children' => [
                ['name' => 'menu4'],
                ['name' => 'menu5'],
                ['name' => 'menu6'],
            ]],
        ];

        foreach ($menus as $menu) {
            AdminMenu::create($menu);
        }

        $this->assertDatabaseCount('admin_menus', 6);

        $menu1 = AdminMenu::new()->where('name', 'menu1')->first();
        $menu2 = AdminMenu::new()->where('name', 'menu2')->first();
        $menu4 = AdminMenu::new()->where('name', 'menu4')->first();

        $this->seedAdmin();

        $this->actingAsAdmin()
            ->putJson('api/admin/admin_menus/'. $menu1['id'], ['name' => 'menu11', 'parent_id' => $menu2['id']])
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $menu1['id'])
            ->assertJsonPath('data.name', 'menu11')
            ->assertJsonPath('data.parent_id', $menu2['id'])
            ->assertOk();

        $this->actingAsAdmin()
            ->putJson('api/admin/admin_menus/'. $menu4['id'], ['name' => 'menu44', 'parent_id' => null])
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $menu4['id'])
            ->assertJsonPath('data.name', 'menu44')
            ->assertJsonPath('data.parent_id', null)
            ->assertOk();
    }

    public function test_show()
    {
        $menus = [
            ['name' => 'menu1'],
            ['name' => 'menu2', 'children' => [
                ['name' => 'menu3'],
            ]],
        ];

        foreach ($menus as $menu) {
            AdminMenu::create($menu);
        }

        $menu1 = AdminMenu::new()->where('name', 'menu1')->first();

        $this->seedAdmin();

        $this->actingAsAdmin()
            ->getJson('api/admin/admin_menus/'. $menu1['id'])
            ->assertJsonPath('data.id', $menu1['id'])
            ->assertOk();
    }

    public function test_destroy()
    {
        $menus = [
            ['name' => 'menu1'],
            ['name' => 'menu2', 'children' => [
                ['name' => 'menu3'],
            ]],
        ];

        foreach ($menus as $menu) {
            AdminMenu::create($menu);
        }

        $menu1 = AdminMenu::new()->where('name', 'menu1')->first();

        $this->seedAdmin()
            ->actingAsAdmin()
            ->deleteJson('api/admin/admin_menus/'.$menu1['id'])
            ->assertOk();

        $this->assertDatabaseMissing('admin_menus', ['id' => $menu1['id']]);
    }
}
