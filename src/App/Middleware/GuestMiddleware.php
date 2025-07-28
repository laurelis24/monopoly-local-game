<?php

namespace App\Middleware;

use App\Auth\Auth;
use App\Router\View;

class GuestMiddleware {
    public static function handle(): void {
        if (Auth::loggedIn()) {
            View::redirect('/');
            exit();
        }
    }
}
