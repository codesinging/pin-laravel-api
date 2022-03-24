<?php

namespace Tests\Feature\Support\Model;

use App\Support\Model\AuthModel;
use App\Support\Model\HelperTraits;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tests\TestCase;

class AuthModelTest extends TestCase
{
    public function test_extends()
    {
        self::assertInstanceOf(User::class, AuthModel::new());
    }

    public function test_traits()
    {
        self::assertArrayHasKey(HasApiTokens::class, class_uses(AuthModel::class));
        self::assertArrayHasKey(Notifiable::class, class_uses(AuthModel::class));

        self::assertArrayHasKey(HelperTraits::class, class_uses(AuthModel::class));
    }
}
