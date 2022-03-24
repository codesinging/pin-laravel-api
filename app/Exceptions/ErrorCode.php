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
}
