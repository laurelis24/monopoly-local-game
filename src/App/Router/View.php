<?php

namespace App\Router;

use Exception;

class View {
    public static function get(string $view, array $data = []) {
        $viewPath = __DIR__ . '/../Views/' . basename($view) . '.php';

        if (!file_exists($viewPath)) {
            throw new Exception("View not found: $viewPath");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        include $viewPath;
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public static function render(string $view, array $data = []): void {
        echo self::get($view, $data);
        exit();
    }

    public static function redirect(string $url, int $code = 200) {
        http_response_code($code);
        header("Location: $url");
        exit();
    }

    public static function errorPage(int $code = 404, array $data = []) {
        http_response_code($code);
        echo self::get('error', ['code' => $code, ...$data]);
        exit();
    }
}
