<?php

namespace App\Controllers;

use App\Router\View;
use App\Models\User;
use App\Request\Request;
use App\Session\Session;
use PDOException;

class AuthController extends BaseController {
    public static function login(Request $request) {
        View::render('login');
    }
    public static function register(Request $request) {
        View::render('register');
    }

    public static function logout(Request $request) {
        Session::destroy();
        View::redirect('/');
    }

    public static function storeUser(Request $request) {

        $validation = $request->validate([
          'username' => 'required|min:3|max:20',
          'password' => 'required|min:8|max:32',
         ]);

        if (!$validation->successful()) {
            Session::setErrors($validation->errors);
            View::redirect('/register');
        }

        try {
            $userId = User::create([
                'username' => $request->input('username'),
                'password' => password_hash($request->input('password'), PASSWORD_BCRYPT),
            ]);

            if ($userId) {
                Session::setParam('user_id', $userId);
                session_regenerate_id(true);
                Session::setParam('token', bin2hex(random_bytes(32)));
            }
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                Session::setErrors(['usernameExists' => 'Username already taken!']);
                View::redirect('/register');
            }
        }

        View::redirect('/');
    }

    public static function loginUser(Request $request) {
        $username = $request->input('username');
        $password =  $request->input('password');

        $user = User::findByUsername($username);

        if ($user) {
            $passwordMatches = password_verify($password, $user->password);
            if ($passwordMatches) {
                Session::setParam('user_id', $user->id);
                Session::generateId(true);
                Session::setParam('token', bin2hex(random_bytes(32)));
                View::redirect('/');
            }
        }

        Session::setErrors(['wrongUsernameOrPassword' => 'Wrong username or password!']);
        View::redirect('/login');

    }
}
