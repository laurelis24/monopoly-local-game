<?php

namespace App\Session;

class Session {
    public static function setParam(string $name, $value) {
        $_SESSION[$name] = $value;
    }

    public static function getParam(string $name) {
        $exists = isset($_SESSION[$name]);
        return $exists ? $_SESSION[$name] : null;
    }

    public static function unsetParam($name) {
        $exists = isset($_SESSION[$name]);
        if ($exists) {
            unset($_SESSION[$name]);
        }
    }
}
