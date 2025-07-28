<?php

namespace App\Middleware;

use App\Auth\Auth;

class AuthMiddleware {
    public static function handle(): void {
        Auth::requireAuth();
    }
}
