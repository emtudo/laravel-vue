<?php

namespace Emtudo\Units\Admin\Users\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'admin_users';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
