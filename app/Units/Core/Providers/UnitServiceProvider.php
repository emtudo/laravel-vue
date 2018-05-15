<?php

namespace Emtudo\Units\Core\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'core';

    protected $hasViews = true;

    protected $providers = [
        RouteServiceProvider::class,
    ];

    public function register()
    {
        parent::register();
    }
}
