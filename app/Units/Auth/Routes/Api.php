<?php

namespace Emtudo\Units\Auth\Routes;

use Emtudo\Support\Http\Routing\RouteFile;

/**
 * Class Api.
 *
 * Authentication API routes.
 */
class Api extends RouteFile
{
    /**
     * Declare API Routes.
     */
    public function routes()
    {
        // Authentication Routes...
        $this->router->get('login', 'LoginController@showLoginForm')->name('login');
        $this->router->post('login', 'LoginController@login');
        $this->router->post('logout', 'LoginController@logout')->name('logout');

        // Registration Routes...
        $this->router->post('register', 'RegisterController@register');

        // Password Reset Routes...
        $this->router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        $this->router->post('password/reset', 'ResetPasswordController@reset');
    }
}
