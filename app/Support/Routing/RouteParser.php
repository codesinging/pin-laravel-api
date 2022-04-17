<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Routing;

use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route as RouteFacade;

class RouteParser
{
    protected Route $route;

    protected ?string $class;
    protected ?string $controller;
    protected ?string $action;

    public function __construct(Route|string $route = null)
    {
        $this->route = empty($route) ? Request::route() : (is_string($route) ? RouteFacade::getRoutes()->getByAction($route) : $route);
        $this->parse();
    }

    /**
     * 获取所有路由或指定前缀的路由集合
     *
     * @param string|null $prefix
     *
     * @return Collection
     */
    public static function collect(string $prefix = null): Collection
    {
        $routes = collect(RouteFacade::getRoutes()->getRoutes());

        return $prefix
            ? $routes->filter(fn(Route $route) => $route->getPrefix() === $prefix)
            : $routes;
    }

    /**
     * 获取所有路由或指定前缀的路由数组
     *
     * @param string|null $prefix
     *
     * @return Route[]
     */
    public static function all(string $prefix = null): array
    {
        return self::collect($prefix)->all();
    }

    /**
     * @return void
     */
    private function parse()
    {
        list($this->class, $this->action) = explode('@', $this->route->getActionName());
        $this->controller = str($this->class)->after('App\\Http\\Controllers\\')->replace('\\', '/');
    }

    /**
     * 返回路由的类名
     *
     * @return string|null
     */
    public function class(): ?string
    {
        return $this->class;
    }

    /**
     * 返回路由的控制器名
     *
     * @return string|null
     */
    public function controller(): ?string
    {
        return $this->controller;
    }

    /**
     * 返回路由的动作名
     *
     * @return string|null
     */
    public function action(): ?string
    {
        return $this->action;
    }
}
