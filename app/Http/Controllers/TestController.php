<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Http\Controllers;

use App\Support\Routing\BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class TestController extends BaseController
{
    public function index()
    {
        return $this->success('test');
    }
}
