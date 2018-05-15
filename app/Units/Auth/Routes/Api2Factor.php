<?php

namespace Emtudo\Units\Auth\Routes;

use Emtudo\Support\Http\Routing\RouteFile;

class Api2Factor extends RouteFile
{
    public function routes()
    {
        // Authentication Routes...
        $this->router->get('two_factor/disabled', 'TwoFactorController@disableTwoFactor')
            ->name('disable_two_factor');
    }
}
