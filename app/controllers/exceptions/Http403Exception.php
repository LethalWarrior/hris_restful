<?php

namespace App\Controllers\Exceptions;

class Http403Exception extends HttpException
{
    public function __construct($message = "Forbidden.")
    {
        parent::__construct(403, $message);
    }
}
