<?php

namespace App\Middlewares;

use App\Auth\Auth;
use App\Router\View;

class GuestMiddleware extends Middleware {
    public function handle(): void {
        if (Auth::loggedIn()) {
            View::redirect('/');
        }
    }
}
