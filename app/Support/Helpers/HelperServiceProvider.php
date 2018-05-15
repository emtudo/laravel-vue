<?php

namespace Emtudo\Support\Helpers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        require_once __DIR__ . '/functions.php';
    }
}
