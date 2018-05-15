<?php

namespace Emtudo\Units\Core\Routes;

use Emtudo\Support\Http\Routing\RouteFile;

class Web extends RouteFile
{
    /**
     * Declare Web Routes.
     */
    public function routes()
    {
        $this->router->get('/', 'WelcomeController@index')->name('index');
    }
}
