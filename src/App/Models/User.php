<?php

namespace App\Models;

use App\Database\DB;
use PDO;

class UserEntity {
    public int $id;
    public string $username;
    public string $password;
}

class User {
    public static function create(array $data) {
        $db = DB::getInstance()->getConnection();

        if (empty($data['username']) || empty($data['password'])) {
            return false;
        }
        $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');

        $success = $stmt->execute([
            ':username' => $data['username'],
            ':password' => $data['password'],
        ]);

        if ($success) {
            return (int) $db->lastInsertId();
        }

        return null;
    }

    public static function findByUsername(string $username): UserEntity | bool {
        $db = DB::getInstance()->getConnection();

        $stmt = $db->prepare('SELECT id, username, password FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, UserEntity::class);
        return $stmt->fetch();
    }

    public static function findById(int $id): UserEntity | bool {
        $db = DB::getInstance()->getConnection();

        $stmt = $db->prepare('SELECT id, username, password FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, UserEntity::class);
        return $stmt->fetch();
    }
}
