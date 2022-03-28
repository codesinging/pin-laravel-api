<?php

namespace Tests\Feature\Support\Routing;

use App\Models\Admin;
use App\Support\Routing\BaseController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ValidateUniqueTest extends TestCase
{
    use RefreshDatabase;

    public function testColumnParameterIsString()
    {
        Admin::new()->create(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        Request::merge(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('name 已经存在');
        (new BaseController())->validateUnique(request(), Admin::new(), 'name');
    }

    public function testColumnParameterIsArray()
    {
        Admin::new()->create(['name' => 'name1', 'username' => 'username1', 'password' => '123']);
        Admin::new()->create(['name' => 'name2', 'username' => 'username2', 'password' => '123']);

        Request::merge(['name' => 'name1', 'username' => 'username2', 'password' => '123']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('name 已经存在');
        $this->expectExceptionMessage('and 1 more error');
        (new BaseController())->validateUnique(request(), Admin::new(), ['name', 'username']);
    }

    public function testMessages()
    {
        Admin::new()->create(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        Request::merge(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('名称已经存在');
        (new BaseController())->validateUnique(request(), Admin::new(), 'name', ['name.unique' => '名称已经存在']);
    }

    public function testAttributes()
    {
        Admin::new()->create(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        Request::merge(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('名称 已经存在');
        (new BaseController())->validateUnique(request(), Admin::new(), 'name', [], ['name' => '名称']);
    }
}
