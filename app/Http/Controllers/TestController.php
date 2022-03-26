<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function index()
    {
        dump($actionName = Request::route()->getActionName());

        dump(Str::between($actionName, 'App\\Http\\Controllers\\', 'Controller@'));
    }
}
