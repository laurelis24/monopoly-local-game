<?php

namespace App\Models;

use App\Auth\Auth;
use App\Database\DB;
use PDO;

class LobbyEntity {
    public int $id;
    public string $name;
    public int $start_money;
    public bool $status;
}

class Lobby extends Model {
    protected static string $table = 'lobbies';

    public static function create(array $data) {
        $db = DB::getInstance()->getConnection();

        if ($data['name'] === null || $data['password'] === null || $data['start_money'] === null) {
            return false;
        }

        $stmt = $db->prepare(
            'INSERT INTO lobbies (name, password, start_money, host_user_id) VALUES (:name, :password, :start_money, :host_user_id)',
        );
        $hostId = Auth::userId();
        return $stmt->execute([
            ':name' => $data['name'],
            ':password' => $data['password'],
            ':start_money' => $data['start_money'],
            ':host_user_id' => $hostId,
        ]);
    }

    public static function findById(int $id): LobbyEntity|bool {
        $db = DB::getInstance()->getConnection();

        $stmt = $db->prepare('SELECT id, name, start_money, status FROM lobbies WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, Lobby::class);
        return $stmt->fetch();
    }
}
