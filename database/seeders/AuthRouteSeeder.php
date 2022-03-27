<?php

namespace Database\Seeders;

use App\Models\AuthRoute;
use App\Support\Routing\RouteParser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Routing\Route;
use ReflectionException;

class AuthRouteSeeder extends Seeder
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
            ->each(fn(Route $route) => AuthRoute::new()->sync($route));
    }
}
