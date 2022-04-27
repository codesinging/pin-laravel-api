<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiniApp;

Route::post('auth/login', [MiniApp\AuthController::class, 'login']);
