<?php

namespace Tests\Feature\Support\Routing;

use App\Support\Routing\ApiResponses;
use App\Support\Routing\BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Tests\TestCase;

class BaseControllerTest extends TestCase
{
    public function test_traits()
    {
        self::assertArrayHasKey(AuthorizesRequests::class, class_uses(BaseController::class));
        self::assertArrayHasKey(DispatchesJobs::class, class_uses(BaseController::class));
        self::assertArrayHasKey(ValidatesRequests::class, class_uses(BaseController::class));

        self::assertArrayHasKey(ApiResponses::class, class_uses(BaseController::class));
    }
}
