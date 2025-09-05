<?php

use App\Router\View;

function abort(int $code = 403, string $message = 'Forbidden') {
    http_response_code($code);
    View::render('error', ['code' => $code, 'message' => $message]);
}
