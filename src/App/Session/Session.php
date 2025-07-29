<?php

namespace App\Session;

class Session {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function setParam(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function getParam(string $key) {
        $exists = isset($_SESSION[$key]);
        return $exists ? $_SESSION[$key] : null;
    }

    public static function unsetParam($name) {
        $exists = isset($_SESSION[$name]);
        if ($exists) {
            unset($_SESSION[$name]);
        }
    }

    public static function setCookieParams(array $params) {
        session_set_cookie_params($params);
    }

    public static function destroy() {
        session_unset();
        session_destroy();

    }

    public static function setHandler(object $sessionHandler, bool $register_shutdown = true) {
        session_set_save_handler($sessionHandler, $register_shutdown);
    }
}
