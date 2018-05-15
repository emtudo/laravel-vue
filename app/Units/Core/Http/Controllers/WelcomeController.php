<?php

namespace Emtudo\Units\Core\Http\Controllers;

use Emtudo\Support\Http\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('core::welcome');
    }
}
