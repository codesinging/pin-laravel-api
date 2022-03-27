<?php

namespace App\Models;

use App\Support\Model\BaseModel;
use App\Support\Reflection\ClassReflection;
use App\Support\Routing\RouteParser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Routing\Route;
use ReflectionException;

class AuthRoute extends BaseModel
{
    protected $fillable = [
        'permission_id',
        'controller',
        'action',
        'controller_title',
        'action_title',
    ];

    protected $with = [
        'permission',
    ];

    /**
     * 获取对应权限的名称
     *
     * @return string
     */
    public function permissionName(): string
    {
        return sprintf('%s:%s@%s', 'route', $this->attributes['controller'], $this->attributes['action']);
    }

    /**
     * 关联权限
     *
     * @return $this
     */
    public function associatePermission(): static
    {
        $permission = AuthPermission::create([
            'name' => $this->permissionName(),
        ]);

        $this->permission()->associate($permission)->save();
        return $this;
    }

    /**
     * 同步权限路由
     *
     * @throws ReflectionException
     */
    public function sync(Route|string $route): static
    {
        $parser = new RouteParser($route);

        $action = $parser->action();

        $reflection = new ClassReflection($parser->class());

        $controllerTitle = $reflection->classTitle();
        $actionTitle = $reflection->methodTitle($action);

        if (!is_null($controllerTitle) && !is_null($actionTitle)) {
            return $this->updateOrCreate([
                'controller' => $parser->controller(),
                'action' => $action,
            ], [
                'controller_title' => $controllerTitle,
                'action_title' => $actionTitle,
            ]);
        }
        return $this;
    }

    /**
     * 当前路由关联的权限模型
     *
     * @return BelongsTo
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(AuthPermission::class, 'permission_id');
    }
}
