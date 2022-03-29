<?php

namespace Tests\Feature\Models;

use App\Http\Controllers\Admin\AuthController;
use App\Models\AdminRoute;
use App\Support\Routing\RouteParser;
use Database\Seeders\AdminRouteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionException;
use Tests\TestCase;

class AdminRouteTest extends TestCase
{
    use RefreshDatabase;

    public function testPermission()
    {
        $this->seed(AdminRouteSeeder::class);

        $adminRoute = AdminRoute::new()->first();

        self::assertEquals($adminRoute['permission_id'], $adminRoute['permission']['id']);
    }

    /**
     * @throws ReflectionException
     */
    public function testSyncFrom()
    {
        $route = AuthController::class . '@login';

        AdminRoute::syncFrom($route);

        $parser = new RouteParser($route);

        $this->assertDatabaseHas(AdminRoute::class, [
            'controller' => $parser->controller(),
            'action' => $parser->action(),
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function testFindFrom()
    {
        $route = AuthController::class . '@login';

        $adminRoute = AdminRoute::syncFrom($route);

        self::assertEquals($adminRoute['id'], AdminRoute::findFrom($route)['id']);
    }
}
