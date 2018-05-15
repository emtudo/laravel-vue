<?php

namespace Emtudo\Support\Exception;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class Handler extends ExceptionHandler implements ExceptionHandlerContract
{
    /**
     * The container implementation.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Container $container)
    {
        // setup local request.
        $this->request = $container->request;

        // parent constructor.
        parent::__construct($container);
    }

    /**
     * Render an exception into a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        $e = $this->prepareException($e);

        if ($e instanceof QueryException) {
            $respond = (new QueryHandler($e))->getRespond();
            if ($respond) {
                return $respond;
            }
        }

        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }
        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $this->prepareResponse($request, $e);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param \Exception $e
     *
     * @return \Exception
     */
    protected function prepareException(Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new HttpException(403, $e->getMessage());
        }

        return $e;
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
        $errors = $e->validator->errors()->getMessages();

        if ($request->expectsJson()) {
            return response()->json([
                'data' => [
                    'error' => array_get(Response::$statusTexts, 422),
                    'errors' => $errors,
                    'code' => 422,
                ],
            ], 422);
        }

        return redirect()->back()->withInput(
            $request->input()
        )->withErrors($errors);
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
        $status = $e->getStatusCode();

        $expectsJson = $this->request->expectsJson();

        if ($expectsJson) {
            return $this->convertExceptionToResponse($e);
        }

        view()->replaceNamespace('errors', [
            resource_path('views/errors'),
            __DIR__.'/views',
        ]);

        if (view()->exists("errors::{$status}")) {
            return response()->view("errors::{$status}", ['exception' => $e], $status, $e->getHeaders());
        }

        return $this->convertExceptionToResponse($e);
    }

    /**
     * Create a Symfony response for the given exception.
     *
     * @param \Exception $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        // flat the exception.
        $e = FlattenException::create($e);

        // detect debug mode.
        $debug = config('app.debug', false);

        if ($this->request->expectsJson()) {
            $message = $e->getMessage();
            $message = $debug || !$message ? array_get(Response::$statusTexts, $e->getStatusCode()) : $message;

            return response()->json(['data' => [
                'error' => $message,
                'code' => $e->getStatusCode(),
                'trace' => $debug ? $e->getTrace() : null,
            ]], $e->getStatusCode(), $e->getHeaders());
        }

        $handler = new SymfonyExceptionHandler(config('app.debug', false));

        return SymfonyResponse::create($handler->getHtml($e), $e->getStatusCode(), $e->getHeaders());
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param \Exception $e
     *
     * @return bool
     */
    protected function isHttpException(Exception $e)
    {
        return $e instanceof HttpException;
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
        if ($request->expectsJson()) {
            return response()->json(['data' => ['error' => 'Unauthenticated.', 'code' => 401]], 401);
        }

        return redirect()->guest('login');
    }
}
