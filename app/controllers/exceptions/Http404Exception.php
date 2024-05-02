<?php

namespace App\Controllers\Exceptions;

class Http404Exception extends HttpException
{
    public function __construct($message = "Not Found.")
    {
        parent::__construct(404, $message);
    }
}
