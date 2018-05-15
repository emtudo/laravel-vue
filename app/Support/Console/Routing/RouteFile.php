<?php

namespace Emtudo\Support\Console\Routing;

use Illuminate\Contracts\Console\Kernel;

abstract class RouteFile
{
    /**
     * @var Kernel
     */
    protected $artisan;

    /**
     * @var Kernel
     */
    protected $router;

    /**
     * RouteFile constructor.
     */
    public function __construct()
    {
        $this->artisan = app(Kernel::class);
        $this->router = $this->artisan;
    }

    /**
     * Register Console Routes.
     */
    public function register()
    {
        return $this->routes();
    }

    /**
     * Declare console routes.
     */
    abstract public function routes();
}
