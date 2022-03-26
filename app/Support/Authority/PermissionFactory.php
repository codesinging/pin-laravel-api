<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Authority;

use App\Support\Routing\RouteParser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;

class PermissionFactory
{
    const PREFIX_ROUTE = 'route';
    const PREFIX_MENU = 'menu';
    const PREFIX_PAGE = 'page';

    /**
     * 生成一个路由的权限名
     *
     * @param Route|RouteParser|string $route
     *
     * @return string
     */
    public static function getNameFromRoute(Route|RouteParser|string $route): string
    {
        $parser = $route instanceof RouteParser ? $route : new RouteParser($route);

        return sprintf('%s:%s@%s', self::PREFIX_ROUTE, $parser->controller(), $parser->action());
    }

    /**
     * 生成一个菜单的权限名
     *
     * @param Model $model
     *
     * @return string
     */
    public static function getNameFromMenu(Model $model): string
    {
        return sprintf('%s:%s@%s', self::PREFIX_MENU, $model->getTable(), $model['id']);
    }

    /**
     * 生成一个页面的权限名
     *
     * @param string $path
     *
     * @return string
     */
    public static function getNameFromPage(string $path): string
    {
        return sprintf('%s:%s', self::PREFIX_PAGE, $path);
    }
}
