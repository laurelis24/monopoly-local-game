<?php

namespace App\Server;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class GameServer implements MessageComponentInterface {
    protected array $players = [];
    protected array $lobbies = [];

    public function onOpen(ConnectionInterface $conn) {
        $this->players[$conn->resourceId] = $conn;
        echo "New connection: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        //echo "Received from {$from->resourceId}: $msg\n";

        //  $from->send("HAHAHAHAH message");
        //echo $msg;
        //   foreach ($this->clients as $client) {
        //if ($from !== $client) {
        //        $client->send($msg);
        //}
        // }
    }

    public function onClose(ConnectionInterface $conn) {
        // unset($this->clients[$conn->resourceId]);
        // echo "Connection {$conn->resourceId} closed\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        // echo "Error: {$e->getMessage()}\n";
        //  $conn->close();
    }
}
