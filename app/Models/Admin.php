<?php

namespace App\Models;

use App\Support\Model\AuthModel;
use App\Support\Model\IsSuperContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Permission\Traits\HasRoles;

class Admin extends AuthModel implements IsSuperContract
{
    use HasRoles;

    protected string $guard_name = 'sanctum';

    protected $fillable = [
        'username',
        'name',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => 'boolean',
        'super' => 'boolean',
    ];

    /**
     * 密码处理
     *
     * @return Attribute
     */
    protected function password(): Attribute
    {
        return new Attribute(
            set: fn($value) => bcrypt($value)
        );
    }

    /**
     * 是否超级管理员
     *
     * @return bool
     */
    public function isSuper(): bool
    {
        return $this->attributes['super'] ?? false;
    }
}
