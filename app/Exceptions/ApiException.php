<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

class ApiException extends \Exception
{
    #[Pure]
    public function __construct(string $message = "", ErrorCode $code = ErrorCode::ERROR, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
