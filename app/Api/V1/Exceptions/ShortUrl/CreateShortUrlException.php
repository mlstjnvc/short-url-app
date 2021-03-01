<?php

namespace App\Api\V1\Exceptions\ShortUrl;

use Exception;
use Throwable;

class CreateShortUrlException extends Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        logger()->critical('Error while creating short url.', [
            'userId' => auth()->id() ?? 'no user, public page',
            'message' => $previous ? $previous->getMessage() : ''
        ]);
    }
}
