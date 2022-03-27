<?php

namespace Tests\Feature\Models;

use App\Http\Controllers\Admin\AuthController;
use App\Models\AuthPermission;
use App\Models\AuthRoute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use ReflectionException;
use Tests\TestCase;

class AuthRouteTest extends TestCase
{
    use RefreshDatabase;

    protected array $data = [
        'controller' => 'Admin/Auth',
        'action' => 'login',
        'controller_title' => '管理员认证',
        'action_title' => '管理员登录',
    ];

    protected string $route = AuthController::class . '@login';

    public function test_permission_name()
    {
        $authRoute = AuthRoute::new()->create($this->data);

        self::assertEquals('route:Admin/Auth@login', $authRoute->permissionName());
    }

    public function test_associate_permission()
    {
        $authRoute = AuthRoute::new()->create($this->data);

        $authRoute->associatePermission();

        $permission = AuthPermission::findByName($authRoute->permissionName());

        self::assertNotNull($permission);
        self::assertEquals($authRoute->permissionName(), $permission['name']);
    }

    /**
     * @throws ReflectionException
     */
    public function test_sync()
    {
        $authRoute = AuthRoute::new()->sync($this->route);

        self::assertEquals('Admin/Auth', $authRoute['controller']);
        self::assertEquals('login', $authRoute['action']);
        self::assertEquals('管理员认证', $authRoute['controller_title']);
        self::assertEquals('管理员登录', $authRoute['action_title']);
    }

    public function test_permission()
    {
        $authRoute = AuthRoute::new()->create($this->data);
        $authRoute->associatePermission();

        self::assertInstanceOf(BelongsTo::class, $authRoute->permission());

        self::assertEquals('route:Admin/Auth@login', $authRoute['permission']['name']);
    }
}
