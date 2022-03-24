<?php

namespace Tests\Feature\Support\Model;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SanitizeTest extends TestCase
{
    public function test_parameter_is_array()
    {
        self::assertEquals(['username' => 'UserName'], Admin::new()->sanitize(['username' => 'UserName', 'other' => 'Other']));
    }

    public function test_parameter_is_request()
    {
        request()->merge(['username' => 'UserName', 'other' => 'Other']);
        self::assertEquals(['username' => 'UserName'], Admin::new()->sanitize(request()));
    }
}
