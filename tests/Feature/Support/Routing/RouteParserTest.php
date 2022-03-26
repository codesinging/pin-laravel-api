<?php

namespace Tests\Feature\Support\Routing;

use App\Http\Controllers\Admin\AuthController;
use App\Support\Routing\RouteParser;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Tests\TestCase;

class RouteParserTest extends TestCase
{
    protected string $routeAction = AuthController::class . '@login';

    protected string $routeClass = AuthController::class;

    public function test_collection()
    {
        self::assertInstanceOf(Collection::class, RouteParser::collect());

        RouteParser::collect('api/admin')->each(fn(Route $route) => self::assertEquals('api/admin', $route->getPrefix()));
    }

    public function test_all()
    {
        self::assertIsArray(RouteParser::all());

        foreach (RouteParser::all('api/admin') as $route) {
            self::assertEquals('api/admin', $route->getPrefix());
        }
    }

    public function test_parse()
    {
        $factory = new RouteParser($this->routeAction);

        self::assertEquals($this->routeClass, $factory->class());
        self::assertEquals('Admin/Auth', $factory->controller());
        self::assertEquals('login', $factory->action());
    }
}
