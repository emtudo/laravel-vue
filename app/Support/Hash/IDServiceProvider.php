<?php

namespace Emtudo\Support\Hash;

use Illuminate\Support\ServiceProvider;

class IDServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('hash.id', function () {
            return new ID();
        });

        require_once __DIR__ . '/functions.php';
    }
}
