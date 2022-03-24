<?php

namespace Tests\Feature\Support\Model;

use App\Support\Model\BaseModel;
use App\Support\Model\HelperTraits;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class BaseModelTest extends TestCase
{
    public function test_extends()
    {
        self::assertInstanceOf(Model::class, BaseModel::new());
    }

    public function test_traits()
    {
        self::assertArrayHasKey(HelperTraits::class, class_uses(BaseModel::class));
    }
}
