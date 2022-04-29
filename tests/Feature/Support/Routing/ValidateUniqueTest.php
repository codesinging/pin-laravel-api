<?php

namespace Tests\Feature\Support\Routing;

use App\Models\Admin;
use App\Support\Routing\BaseController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ValidateUniqueTest extends TestCase
{
    use RefreshDatabase;

    public function testColumnsParameterIsString()
    {
        Admin::creates(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        Request::merge(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('name 已经存在');

        (new BaseController())->validateUnique('name', request(), Admin::new());
    }

    public function testColumnsParameterIsArray()
    {
        Admin::new()->create(['name' => 'name1', 'username' => 'username1', 'password' => '123']);
        Admin::new()->create(['name' => 'name2', 'username' => 'username2', 'password' => '123']);

        Request::merge(['name' => 'name1', 'username' => 'username2', 'password' => '123']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('name 已经存在');
        $this->expectExceptionMessage('and 1 more error');

        (new BaseController())->validateUnique(['name', 'username'], request(), Admin::new());
    }

    public function testStore()
    {
        Admin::creates(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        Request::merge(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('name 已经存在');

        (new BaseController())->validateUnique('name', request(), Admin::new());
    }

    public function testUpdate()
    {
        Admin::creates(['name' => 'name1', 'username' => 'username1', 'password' => '123']);
        $admin = Admin::creates(['name' => 'name2', 'username' => 'username2', 'password' => '123']);

        Request::merge(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('name 已经存在');

        (new BaseController())->validateUnique('name', request(), $admin);
    }

    public function testMessages()
    {
        Admin::new()->create(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        Request::merge(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('名称已经存在');
        (new BaseController())->validateUnique('name', request(), Admin::new(), ['name.unique' => '名称已经存在']);
    }

    public function testAttributes()
    {
        Admin::new()->create(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        Request::merge(['name' => 'name1', 'username' => 'username1', 'password' => '123']);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('名称 已经存在');
        (new BaseController())->validateUnique('name', request(), Admin::new(), [], ['name' => '名称']);
    }
}
