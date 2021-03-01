<?php

namespace App\Api\V1\Exceptions\Auth;

use Exception;
use Throwable;

class GetTokenException extends Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        logger()->critical('Error while fetching token.', ['message' => $previous ? $previous->getMessage() : '']);
    }
}
