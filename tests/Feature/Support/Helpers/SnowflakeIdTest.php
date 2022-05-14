<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace Tests\Feature\Support\Helpers;

use App\Support\Helpers\SnowflakeId;
use Tests\TestCase;

class SnowflakeIdTest extends TestCase
{
    public function testId()
    {
        self::assertIsInt(SnowflakeId::id());
        self::assertGreaterThanOrEqual(18, strlen(SnowflakeId::id()));
    }

    public function testShortId()
    {
        self::assertIsInt(SnowflakeId::id());
        self::assertLessThanOrEqual(15, strlen(SnowflakeId::shortId()));
    }
}
