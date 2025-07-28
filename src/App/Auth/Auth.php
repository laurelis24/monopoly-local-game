<?php

namespace App\Auth;

use App\Router\View;

class Auth {
    public static function loggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function userId() {
        return $_SESSION['user_id'];
    }

    public static function requireAuth() {
        if (!static::loggedIn()) {
            View::redirect('/login');
            exit;
        }
    }

}
