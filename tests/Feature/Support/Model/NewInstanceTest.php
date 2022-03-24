<?php

namespace Tests\Feature\Support\Model;

use App\Support\Model\BaseModel;
use Tests\TestCase;

class NewInstanceTest extends TestCase
{
    public function test_instance()
    {
        self::assertInstanceOf(BaseModel::class, BaseModel::new());
    }
}
