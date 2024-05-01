<?php

namespace App\Controllers\Exceptions;

class Http500Exception extends HttpException
{
    public function __construct($message = "Internal server error.")
    {
        parent::__construct(500, $message);
    }
}
