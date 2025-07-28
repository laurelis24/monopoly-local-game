<?php

require __DIR__ . '/../../../vendor/autoload.php';
use App\Server\GameServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(new HttpServer(new WsServer(new GameServer())), 8001, '0.0.0.0');

echo 'Server started!';
$server->run();
