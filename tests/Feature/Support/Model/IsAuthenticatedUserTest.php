<?php

namespace Tests\Feature\Support\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\AdminActing;
use Tests\TestCase;

class IsAuthenticatedUserTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function test_not_authenticated()
    {
        $this->seedAdmin();
        $admin = $this->getAdmin();

        self::assertFalse($admin->isAuthenticatedUser());
    }

    public function test_authenticated()
    {
        $this->seedAdmin();
        $admin1 = $this->getAdmin(['id' => 1]);
        $admin2 = $this->getAdmin(['id' => 2]);

        Auth::login($admin1);

        self::assertTrue($admin1->isAuthenticatedUser());
        self::assertFalse($admin2->isAuthenticatedUser());
    }
}
