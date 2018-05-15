<?php

namespace Emtudo\Units\User\Users\Routes;

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
        $this->router->get('profile', 'ProfileController@show');
        $this->router->put('profile', 'ProfileController@update');
    }
}
