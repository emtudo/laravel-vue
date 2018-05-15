<?php

namespace Emtudo\Units\Core\Http\Middleware;

use Closure;
use Emtudo\Domains\Users\User;
use Illuminate\Auth\Access\AuthorizationException;

class Admin
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

        if (!$user->isAdmin()) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
