<?php

namespace Tests\Feature\Support\Model;

use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\AdminActing;
use Tests\TestCase;

class SerializeDateTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function test_date_format()
    {
        $this->freezeTime();
        $this->seedAdmin();

        $admin = $this->getAdmin();

        self::assertEquals(date('Y-m-d H:i:s'), $admin->toArray()['created_at']);
    }
}
