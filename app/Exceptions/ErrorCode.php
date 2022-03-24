<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Exceptions;

enum ErrorCode: int
{
    case OK = 0;

    case ERROR = -1;

    case SUPER_ADMIN_UPDATE_ERROR = 900100;
    case SUPER_ADMIN_DELETE_ERROR = 900101;

    case VALIDATION_ERROR = 900200;

    case AUTH_USER_NOT_EXISTED = 900300;
    case AUTH_PASSWORD_NOT_MATCHED = 900301;
    case AUTH_USER_STATUS_ERROR = 900302;
}
