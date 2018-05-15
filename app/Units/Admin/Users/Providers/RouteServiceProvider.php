<?php

namespace Emtudo\Units\Admin\Users\Providers;

use Emtudo\Units\Admin\Users\Routes\Api;
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
    protected $namespace = 'Emtudo\Units\Admin\Users\Http\Controllers';

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        (new Api([
            'middleware' => ['api', 'auth', 'admin', 'twoFactorVerify'],
            'namespace' => $this->namespace,
            'prefix' => 'v1/admin/users',
            'as' => 'admin::users::',
        ]))->register();
    }
}
