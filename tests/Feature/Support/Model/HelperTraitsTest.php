<?php

namespace Tests\Feature\Support\Model;

use App\Support\Model\HelperTraits;
use App\Support\Model\NewInstance;
use App\Support\Model\QueryLister;
use App\Support\Model\Sanitize;
use App\Support\Model\SerializeDate;
use App\Support\Model\UniqueRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

class HelperTraitsTest extends TestCase
{
    public function test_traits()
    {
        self::assertArrayHasKey(HasFactory::class, class_uses(HelperTraits::class));
        self::assertArrayHasKey(NewInstance::class, class_uses(HelperTraits::class));
        self::assertArrayHasKey(SerializeDate::class, class_uses(HelperTraits::class));
        self::assertArrayHasKey(Sanitize::class, class_uses(HelperTraits::class));
        self::assertArrayHasKey(QueryLister::class, class_uses(HelperTraits::class));
    }
}
