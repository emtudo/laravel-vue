<?php

namespace Emtudo\Units\Auth\Providers;

use Emtudo\Units\Auth\Routes\Api;
use Emtudo\Units\Auth\Routes\Api2Factor;
use Emtudo\Units\Auth\Routes\ApiAuth;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Emtudo\Units\Auth\Http\Controllers';

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        (new Api([
            'middleware' => ['api'],
            'namespace' => $this->namespace,
            'prefix' => 'v1/auth',
            'as' => 'auth::',
        ]))->register();

        (new ApiAuth([
            'middleware' => ['api', 'auth'],
            'namespace' => $this->namespace,
            'prefix' => 'v1/auth',
            'as' => 'auth::',
        ]))->register();

        (new Api2Factor([
            'middleware' => ['api', 'auth', 'twoFactorVerify'],
            'namespace' => $this->namespace,
            'prefix' => 'v1/auth',
            'as' => 'auth::',
        ]))->register();
    }
}
