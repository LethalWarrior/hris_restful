<?php

namespace App\Controllers\Exceptions;

use Exception;

class HttpException extends Exception
{
    protected $statusCode;

    public function __construct($statusCode, $message)
    {
        $this->statusCode = $statusCode;
        parent::__construct($message);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
