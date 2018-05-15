<?php

namespace Emtudo\Units\Admin\Providers;

use Emtudo\Support\Units\ServiceProvider;
use Emtudo\Units\Admin\Users\Providers\UnitServiceProvider as UserUnitServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'admin';

    protected $providers = [
        UserUnitServiceProvider::class,
    ];
}
