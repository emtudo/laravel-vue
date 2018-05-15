<?php

namespace Emtudo\Units\Core\Providers;

use Emtudo\Units\Core\Routes\Web;
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
    protected $namespace = 'Emtudo\Units\Core\Http\Controllers';

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        (new Web([
            'namespace' => $this->namespace,
            'as' => 'web::',
        ]))->register();
    }
}
