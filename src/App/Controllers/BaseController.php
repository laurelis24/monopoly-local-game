<?php

namespace App\Controllers;

use App\Router\View;
use App\Validation\Validator;

class BaseController {
    // protected static Validator $validator;

    public function __construct() {
        // self::$validator = new Validator();
    }


    public static function abort(int $code, array $messages) {
        http_response_code($code);
        return View::render('error', [
            'code' => $code,
            'messages' => $messages,
        ]);
    }
}
