<?php

namespace Emtudo\Units\Core\Http\Middleware;

use Closure;
use Emtudo\Domains\Users\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;

class TwoFactorVerify
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @throws AuthorizationException
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if (!$user->twoFactorEnabled()) {
            return $next($request);
        }

        if (!$this->twoFactoryIsValid($request)) {
            throw new AuthorizationException();
        }

        User::$twoFactoryIsValid = true;

        return $next($request);
    }

    protected function twoFactoryIsValid($request)
    {
        $token = $this->detectedToken($request);
        if (!$token) {
            return false;
        }

        $payload = explode('.', $token)[1];
        if (!$payload) {
            return false;
        }
        $payload = json_decode(base64_decode($payload, true), true);

        return isset($payload['two_factor']) && $payload['two_factor'];
    }

    /**
     * @param mixed $request
     *
     * @return null|Token
     */
    protected function detectedToken($request)
    {
        // retrieve the token from the Authorization header.
        $headerToken = $this->getTokenFromHeader($request);

        // if a token was found...
        if ($headerToken) {
            return $headerToken;
        }

        // try to find a token passed as parameter on the request.
        $parameterToken = $this->getTokenFromParameter($request);

        // if found...
        if ($parameterToken) {
            return $parameterToken;
        }

        // return null if no token could be found.
        return null;
    }

    /**
     * Parse the request looking for the authorization header.
     *
     * @param mixed $request
     *
     * @return null|string
     */
    protected function getTokenFromHeader($request)
    {
        // if there is no authorization header present.
        if (!$request->headers->has('Authorization')) {
            // abort by returning null.
            return null;
        }

        // gets the full header string.
        $header = $request->headers->get('Authorization');

        // returns the token without the 'Bearer ' prefix.
        return Str::replaceFirst('Bearer ', '', $header);
    }

    /**
     * Parse the request looking a token as parameter.
     *
     * @param mixed $request
     *
     * @return null|string
     */
    protected function getTokenFromParameter($request)
    {
        if (!$request->has('token')) {
            // abort by returning null.
            return null;
        }

        //  return the request token.
        return $request->get('token', null);
    }
}
