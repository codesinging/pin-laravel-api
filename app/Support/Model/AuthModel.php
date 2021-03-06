<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Model;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AuthModel extends User
{
    use HasApiTokens;
    use Notifiable;

    use HelperTraits;

    use IsAuthenticatedUser;
}
