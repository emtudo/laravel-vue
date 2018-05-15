<?php

namespace Emtudo\Support\Http;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        $request = $this->app['request'];

        if ($request->is('api*')) {
            $request->headers->add(['accept' => 'application/json']);
        }
    }
}
