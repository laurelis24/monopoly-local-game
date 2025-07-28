<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Router\View;

class MainController {
    public static function index() {
        // if (!$_SESSION["username"]){
        //     View::redirect("login");
        // }
        View::render('main', [
            'isLoggedIn' => Auth::loggedIn(),
        ]);
    }
}
