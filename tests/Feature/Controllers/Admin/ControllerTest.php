<?php

namespace Tests\Feature\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Support\Routing\BaseController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    public function testExtend()
    {
        self::assertInstanceOf(BaseController::class, new Controller());
    }
}
