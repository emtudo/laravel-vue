<?php

namespace Emtudo\Units\Admin\Users\Routes;

use Emtudo\Support\Http\Routing\RouteFile;

/**
 * Api Routes.
 *
 * This file is where you may define all of the routes that are handled
 * by your application. Just tell Laravel the URIs it should respond
 * to using a Closure or controller method. Build something great!
 */
class Api extends RouteFile
{
    public function routes()
    {
        $this->router->put('users/{user}/activate', 'UserController@activate');
        $this->router->put('users/{user}/suspend', 'UserController@suspend');
        $this->router->apiResource('users', 'UserController');
    }
}
