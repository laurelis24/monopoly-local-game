<?php

namespace App\Middlewares;

use App\Auth\Auth;

class AuthMiddleware extends Middleware {
    public function handle(): void {
        Auth::requireAuth();
    }
}
