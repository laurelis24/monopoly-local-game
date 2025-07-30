<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Router\View;

class MainController {
    public static function index() {
        View::render('main', [
            'isLoggedIn' => Auth::loggedIn(),
        ]);
    }
}
