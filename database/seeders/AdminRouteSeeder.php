<?php

namespace Database\Seeders;

use App\Models\AdminRoute;
use App\Support\Reflection\ClassReflection;
use App\Support\Routing\RouteParser;
use Illuminate\Database\Seeder;
use Illuminate\Routing\Route;
use ReflectionException;

class AdminRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws ReflectionException
     */
    public function run()
    {
        RouteParser::collect('api/admin')
            ->each(fn(Route $route) => $this->sync($route));
    }

    /**
     * @throws ReflectionException
     */
    public function sync(Route|string $route)
    {
        $parser = new RouteParser($route);

        $action = $parser->action();

        $reflection = new ClassReflection($parser->class());

        $controllerTitle = $reflection->classTitle();
        $actionTitle = $reflection->methodTitle($action);

        if (!is_null($controllerTitle) && !is_null($actionTitle)) {
            AdminRoute::new()->updateOrCreate([
                'controller' => $parser->controller(),
                'action' => $action,
            ], [
                'controller_title' => $controllerTitle,
                'action_title' => $actionTitle,
            ]);
        }
    }
}
