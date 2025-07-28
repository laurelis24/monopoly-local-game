<?php

namespace App\Controllers;

use App\Models\Lobby;
use App\Router\View;
use App\Session\Session;
use PDOException;

class LobbyController {
    public static function index() {
        View::render('lobbies', [
            'lobbies' => Lobby::select(['id', 'name', 'start_money', 'status']),
        ]);
    }

    public static function create() {
        View::render('createLobby');
    }

    public static function show(string $id, string $name) {

        //View::redirect("/");
        echo 'haha';
    }

    public static function storeLobby() {
        $token = $_POST['token'] ?? null;
        $name = $_POST['name'] ?? null;
        $password = $_POST['password'] ?? null;
        $startMoney = $_POST['start_money'] ?? null;

        if ($token !== Session::getParam('token')) {
            http_response_code(403);
            echo '<h1>Error 403</h1><p>Wrong CSRF token!</p>';
            exit;
        }

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
