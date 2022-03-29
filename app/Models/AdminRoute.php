<?php

namespace App\Models;

use App\Events\AdminRouteDeleted;
use App\Events\AdminRouteCreated;
use App\Support\Model\AuthPermissionContract;
use App\Support\Model\BaseModel;
use App\Support\Reflection\ClassReflection;
use App\Support\Routing\RouteParser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Routing\Route;
use ReflectionException;

class AdminRoute extends BaseModel implements AuthPermissionContract
{
    protected $fillable = [
        'controller',
        'action',
        'controller_title',
        'action_title',
    ];

    protected $dispatchesEvents = [
        'created' => AdminRouteCreated::class,
        'deleted' => AdminRouteDeleted::class,
    ];

    protected $with = [
        'permission',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(AdminAuthPermission::class, 'permission_id');
    }

    /**
     * 根据路由同步
     *
     * @throws ReflectionException
     */
    public static function syncFrom(Route|string $route): Model|AdminRoute|null
    {
        $parser = new RouteParser($route);

        $action = $parser->action();

        $reflection = new ClassReflection($parser->class());

        $controllerTitle = $reflection->classTitle();
        $actionTitle = $reflection->methodTitle($action);

        if (!is_null($controllerTitle) && !is_null($actionTitle)) {
            return AdminRoute::new()->updateOrCreate([
                'controller' => $parser->controller(),
                'action' => $action,
            ], [
                'controller_title' => $controllerTitle,
                'action_title' => $actionTitle,
            ]);
        }
        return null;
    }

    /**
     * 根据路由查找
     *
     * @param Route|string $route
     *
     * @return AdminRoute|null
     */
    public static function findFrom(Route|string $route): AdminRoute|null
    {
        $parser = new RouteParser($route);

        return self::new()->where('controller', $parser->controller())
            ->where('action', $parser->action())
            ->first();
    }
}
