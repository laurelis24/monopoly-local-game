<?php

namespace App\Auth;

use App\Router\View;
use App\Session\Session;

class Auth {
    public static function loggedIn() {
        return Session::getParam('user_id') !== null;
    }

    public static function userId() {
        return Session::getParam('user_id');
    }

    public static function requireAuth() {
        if (!static::loggedIn()) {
            View::redirect('/login');
            exit();
        }
    }
}
