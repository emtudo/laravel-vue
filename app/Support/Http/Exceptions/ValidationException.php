<?php

namespace Emtudo\Support\Http\Exceptions;

use Illuminate\Validation\ValidationException as LaravelValidationException;

class ValidationException extends LaravelValidationException
{
    /**
     * Create a new exception instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param string                                     $message
     */
    public function __construct($validator, $response = null, $message = null)
    {
        parent::__construct($validator, $response);

        $this->message = $message ?? 'Os dados informados falharam a validação.';
    }
}
