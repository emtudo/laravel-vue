<?php

namespace Emtudo\Units\Auth\Routes;

use Emtudo\Support\Http\Routing\RouteFile;

class ApiAuth extends RouteFile
{
    /**
     * Declare API Routes.
     */
    public function routes()
    {
        // Authentication Routes...
        $this->router->get('user', 'LoginController@user')
            ->name('user');

        $this->router->post('two_factor/active', 'TwoFactorController@activeTwoFactor')
            ->name('enable_two_factor');

        $this->router->post('two_factor/verify', 'TwoFactorController@verifyCode')
            ->name('vefiry_two_factor');
    }
}
