<?php

namespace App\Router;

use App\Session\Session;
use Exception;

class View {
    public static function get(string $view, array $data = []): string {
        $viewPath = __DIR__ . '/../Views/' . $view . 'View.php';

        if (!file_exists($viewPath)) {
            throw new Exception("View not found: $viewPath");
        }

        extract($data);

        ob_start();
        require $viewPath;
        return ob_get_clean();
    }

    public static function render(string $view, array $data = []): void {
        echo self::get($view, $data);
        Session::unsetParam('usernameError');
        exit();
    }

    public static function redirect(string $url) {
        header("Location: $url");
        exit();
    }

    public static function errorPage(array $data = []) {
        echo self::get('404', $data);
        exit();
    }
}
