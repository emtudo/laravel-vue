<?php

namespace Emtudo\Support\Validators;

use Illuminate\Support\ServiceProvider;

class CustomValidatorServiceProvider extends ServiceProvider
{
    protected $validator;

    public function boot()
    {
        $this->app->validator->resolver(function ($translator, $data, $rules, $messages, $attributes) {
            return new Validator($translator, $data, $rules, $messages, $attributes);
        });
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }
}
