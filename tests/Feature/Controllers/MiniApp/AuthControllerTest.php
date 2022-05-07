<?php

namespace Tests\Feature\Controllers\MiniApp;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WechatUserActing;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    use WechatUserActing;

    public function testUser()
    {
        $this->seedWechatUser();

        $user = $this->getWechatUser();

        $this->actingAsWechatUser($user)
            ->getJson('api/mini/auth/user')
            ->assertJsonPath('code', 0)
            ->assertJsonPath('data.id', $user['id'])
            ->assertOk();
    }
}
