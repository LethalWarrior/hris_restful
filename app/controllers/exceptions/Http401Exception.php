<?php

namespace App\Controllers\Exceptions;

class Http401Exception extends HttpException
{
    public function __construct($message = "Unauthorized.")
    {
        parent::__construct(401, $message);
    }
}
