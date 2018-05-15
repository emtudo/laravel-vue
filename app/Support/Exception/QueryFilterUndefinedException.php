<?php

namespace Emtudo\Support\Exception;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QueryFilterUndefinedException extends HttpException
{
    protected $statusCode = 500;
    protected $exceptionType = 'QueryFilter não definido';

    public function __construct($message = null, Exception $previous = null, $headers = [], $code = 0)
    {
        if (null === $message) {
            $message = $this->exceptionType;
        }
        parent::__construct($this->statusCode, $message, $previous, $headers, $code);
    }
}
