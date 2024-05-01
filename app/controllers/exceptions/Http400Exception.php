<?php

namespace App\Controllers\Exceptions;

class Http400Exception extends HttpException
{
    protected $details;

    public function __construct($message = "Bad Request.", $details = "")
    {
        $this->details = $details;
        parent::__construct(400, $message);
    }

    public function getDetails()
    {
        return $this->details;
    }
}
