<?php

namespace Baijunyao\LaravelRestful\Exceptions;

use \Exception;
use \Throwable;

class LaravelRestfulException extends Exception
{
    /**
     * LaravelRestfulException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}