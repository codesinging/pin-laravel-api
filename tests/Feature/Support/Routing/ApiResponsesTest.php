<?php

namespace Tests\Feature\Support\Routing;

use App\Exceptions\ErrorCode;
use App\Support\Routing\BaseController;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class ApiResponsesTest extends TestCase
{
    public function test_success()
    {
        self::assertInstanceOf(JsonResponse::class, (new BaseController())->success());

        self::assertEquals(200, (new BaseController())->success()->status());
        self::assertEquals('success', (new BaseController())->success('success')->getData(true)['message']);
        self::assertEquals(0, (new BaseController())->success('success')->getData(true)['code']);
        self::assertEquals(['id' => 1], (new BaseController())->success('success', ['id' => 1])->getData(true)['data']);
        self::assertEquals(['id' => 1], (new BaseController())->success(['id' => 1])->getData(true)['data']);
    }

    public function test_error()
    {
        self::assertInstanceOf(JsonResponse::class, (new BaseController())->error());

        self::assertEquals(200, (new BaseController())->error()->status());
        self::assertEquals('error', (new BaseController())->error('error')->getData(true)['message']);
        self::assertEquals(ErrorCode::ERROR->value, (new BaseController())->error()->getData(true)['code']);
        self::assertEquals(ErrorCode::VALIDATION_ERROR->value, (new BaseController())->error('error', ErrorCode::VALIDATION_ERROR)->getData(true)['code']);
    }
}
