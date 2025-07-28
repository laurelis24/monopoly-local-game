<?php

namespace App\Controllers;

use App\Router\View;

class BaseController {
    public static function abort(int $code, $message) {
        http_response_code($code);
        return View::render('404', [
            'code' => $code,
            'message' => $message,
        ]);
    }
}
