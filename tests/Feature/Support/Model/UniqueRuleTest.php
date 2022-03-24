<?php

namespace Tests\Feature\Support\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rule;
use Tests\AdminActing;
use Tests\TestCase;

class UniqueRuleTest extends TestCase
{
    use RefreshDatabase;
    use AdminActing;

    public function test_rule()
    {
        $this->seedAdmin();

        $admin = $this->getAdmin();

        self::assertEquals(Rule::unique('admins')->ignore($admin), $admin->uniqueRule());
    }
}
