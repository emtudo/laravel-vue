<?php

namespace Emtudo\Units\User\Providers;

use Emtudo\Support\Units\ServiceProvider;
use Emtudo\Units\User\Users\Providers\UnitServiceProvider as UserUnitServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'user';

    protected $providers = [
        UserUnitServiceProvider::class,
    ];
}
