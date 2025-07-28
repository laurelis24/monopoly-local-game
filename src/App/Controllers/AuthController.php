<?php

namespace App\Controllers;

use App\Router\View;
use App\Models\User;
use App\Session\Session;
use PDOException;

class AuthController {
    public static function login() {
        View::render('login');
    }
    public static function register() {
        View::render('register');
    }

    public static function logout() {
        Session::destroy();
        View::redirect('/');
    }

    public static function storeUser() {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        try {
            $userId = User::create([
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT),
            ]);

            if ($userId) {
                Session::setParam('user_id', $userId);
                session_regenerate_id(true);
                Session::setParam('token', bin2hex(random_bytes(32)));
                return View::redirect('/');
            }
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                Session::setParam('usernameError', 'Username already taken!');
                return View::redirect('/register');
            }
        }

        return View::redirect('/');
    }

    public static function loginUser() {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        $user = User::findByUsername($username);

        if ($user) {
            $passwordMatches = password_verify($password, $user->password);
            if ($passwordMatches) {
                Session::setParam('user_id', $user->id);
                session_regenerate_id(true);
                Session::setParam('token', bin2hex(random_bytes(32)));
                return View::redirect('/');
            } else {
                return View::render('/login', [
                    'error' => 'Wrong username or password!',
                ]);
            }
        } else {
            return View::render('/login', [
                'error' => 'Wrong username or password!',
            ]);
        }
    }
}
