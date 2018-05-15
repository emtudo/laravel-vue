<?php

namespace Emtudo\Units\User\Users\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'user_users';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
