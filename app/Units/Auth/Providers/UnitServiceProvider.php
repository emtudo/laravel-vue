<?php

namespace Emtudo\Units\Auth\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'auth';

    protected $hasViews = true;

    protected $providers = [
        AuthServiceProvider::class,
        RouteServiceProvider::class,
    ];
}
