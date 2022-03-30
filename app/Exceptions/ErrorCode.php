<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Exceptions;

class ErrorCode
{
    const OK = 0;

    const ERROR = -1;

    const SUPER_ADMIN_UPDATE_ERROR = 900100;
    const SUPER_ADMIN_DELETE_ERROR = 900101;

    const VALIDATION_ERROR = 900200;

    const AUTH_USER_NOT_EXISTED = 900300;
    const AUTH_PASSWORD_NOT_MATCHED = 900301;
    const AUTH_USER_STATUS_ERROR = 900302;
}
