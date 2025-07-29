<?php

namespace App\Session;

use App\Database\DB;
use PDO;
use SessionHandlerInterface;

class SessionHandler implements SessionHandlerInterface {
    private $pdo;
    private $key;

    public function __construct() {
        $this->pdo = DB::getInstance()->getConnection();
        $this->key = $_ENV['SESSION_ENCRYPTION_KEY'] ?? 'key123';
    }

    public function open($savePath, $sessionName): bool {
        return true;
    }

    public function close(): bool {
        return true;
    }


    public function read($id): string {
        $stmt = $this->pdo->prepare('SELECT data, iv, tag FROM sessions WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return '';
        }

        return openssl_decrypt($row['data'], 'aes-256-gcm', $this->key, OPENSSL_RAW_DATA, $row['iv'], $row['tag']) ?: '';
    }

    public function write($id, $data): bool {
        $time = time();
        $stmt = $this->pdo->prepare('
        REPLACE INTO sessions (id, data, iv, tag, last_activity) VALUES (?, ?, ?, ?, ?)
    ');

        $key = $this->key;
        $iv = random_bytes(12);
        $tag = '';

        $encryptedData = openssl_encrypt($data, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);

        return $stmt->execute([$id, $encryptedData, $iv, $tag, $time]);
    }

    public function destroy($id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM sessions WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function gc($maxLifetime): int|false {
        $old = time() - $maxLifetime;
        $stmt = $this->pdo->prepare('DELETE FROM sessions WHERE last_activity < ?');
        return $stmt->execute([$old]);
    }


}
