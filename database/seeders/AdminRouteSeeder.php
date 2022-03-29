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
            ->each(fn(Route $route) => AdminRoute::syncFrom($route));
    }

}
