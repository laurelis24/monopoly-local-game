<?php

namespace App\Controllers;

use App\Models\Lobby;
use App\Router\View;
use App\Session\Session;
use PDOException;

class LobbyController extends BaseController {
    public static function index() {
        //  $lobbies = Lobby::select(['lobbies.id', 'username as host_user', 'name'])->join('users', 'users.id', '=', 'lobbies.host_user_id')->get();

        // View::render('lobbies', [
        //     'lobbies' => $lobbies]);
    }

    public static function create() {
        View::render('createLobby');
    }

    public static function show(string $id) {
        //  $lobby = Lobby::select(["id", "name", "host_user_id", ""])->
        // echo 'haha';
    }

    public static function storeLobby() {
        $token = $_POST['token'] ?? null;
        $name = $_POST['name'] ?? null;
        $password = $_POST['password'] ?? null;
        $startMoney = $_POST['start_money'] ?? null;

        if ($token !== Session::getParam('token')) {
            static::abort(403, ['Wrong CSRF token!']);
        }

        // if ($name === null || $password === null || $startMoney === null) {
        //     static::abort(403, 'Wrong inputs');
        // }
        //$validaror =
        //   $validator = self::$validate->validate();

        try {
            Lobby::create([
                'name' => $name,
                'password' => $password,
                'start_money' => $startMoney,
            ]);
        } catch (PDOException $e) {
            //throw $th;
        }

        return View::redirect('/lobbies');
    }
}
