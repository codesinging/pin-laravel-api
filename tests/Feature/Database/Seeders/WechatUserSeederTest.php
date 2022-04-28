<?php

namespace Tests\Feature\Database\Seeders;

use App\Models\WechatUser;
use Database\Seeders\WechatUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WechatUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testSeeder()
    {
        $this->seed(WechatUserSeeder::class);

        $wechatUser = WechatUser::new()->inRandomOrder()->first();

        self::assertEquals(11, strlen($wechatUser['mobile']));

        $this->assertModelExists($wechatUser);
        $this->assertDatabaseCount(WechatUser::class, 50);
        $this->assertDatabaseHas(WechatUser::class, ['status' => true]);
        $this->assertDatabaseHas(WechatUser::class, ['status' => false]);
    }
}
