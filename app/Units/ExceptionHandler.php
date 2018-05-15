<?php

namespace Emtudo\Units;

use Emtudo\Support\Exception\Handler;
use Emtudo\Support\Exception\QueryFilterUndefinedException;
use Emtudo\Support\Exception\RepositoryUndefinedException;
use Emtudo\Support\Exception\UploadFileFailedException;
use Emtudo\Support\Http\Respond;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionHandler extends Handler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Exception $exception
     */
    public function report(Exception $exception)
    {
        $sentryEnvironments = ['production', 'staging'];

        parent::report($exception);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param \Illuminate\Validation\ValidationException $e
     * @param \Illuminate\Http\Request                   $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        // get the failed validation messages.
        $errors = $e->validator->errors()->getMessages();
        $respond = new Respond();

        return $respond->invalid($errors, $e->getMessage());
//        // returns an failed validation response.
//        return response()->json([
//            'data' => [
//                'error' => $e->getMessage(),
//                'errors' => $errors,
//                'code' => 422
//            ]
//        ], 422);
    }

    /**
     * Render the given HttpException.
     *
     * @param \Symfony\Component\HttpKernel\Exception\HttpException $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        if ($e instanceof UploadFileFailedException) {
            $respond = new Respond();

            return $respond->invalid([
                'attachment' => $e->getMessage(),
            ], $e->getMessage());
        }

        if ($e instanceof RepositoryUndefinedException) {
            $respond = new Respond();

            return $respond->invalid($e->getMessage(), $e->getMessage());
        }

        if ($e instanceof QueryFilterUndefinedException) {
            $respond = new Respond();

            return $respond->invalid($e->getMessage());
        }

        parent::renderHttpException($e);

        return $this->convertExceptionToResponse($e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request                 $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // returns a default authentication exception.
        return response()->json(['data' => ['error' => 'Unauthenticated.', 'code' => 401]], 401);
    }

    /**
     * Flatten the stack trace into a simple format.
     *
     * @param array $stackTrace
     *
     * @return array
     */
    protected function flattenTrace(array $stackTrace = [])
    {
        $trace = collect((array) $stackTrace);

        return $trace->map(function ($error) {
            return collect((array) $error)->only(['class', 'file', 'line']);
        })->all();
    }
}
