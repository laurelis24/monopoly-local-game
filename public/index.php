<?php

require_once '../configurations/config.php';
use App\Controllers\MainController;
use App\Router\Router;
use App\Controllers\AuthController;
use App\Controllers\LobbyController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

session_set_cookie_params([
   'lifetime' => 1800,
]);

ini_set('session.gc_maxlifetime', 1800);

session_start();
$router = new Router();

// main menu
$router->get('/', [MainController::class, 'index']);

// register and login/logout
$router->get('/login', [AuthController::class, 'login'])->middleware(GuestMiddleware::class);
$router->post('/login', [AuthController::class, 'loginUser'])->middleware(GuestMiddleware::class);
$router->post('/logout', [AuthController::class, 'logout'])->middleware(AuthMiddleware::class);
$router->get('/register', [AuthController::class, 'register'])->middleware(GuestMiddleware::class);
$router->post('/register', [AuthController::class, 'storeUser'])->middleware(GuestMiddleware::class);


// lobby
$router->get('/lobbies', [LobbyController::class, 'index'])->middleware(AuthMiddleware::class);
$router->get('/lobby/create', [LobbyController::class, 'create'])->middleware(AuthMiddleware::class);
$router->post('/lobby/create', [LobbyController::class, 'storeLobby'])->middleware(AuthMiddleware::class);
$router->get('/lobby/{id}/product/{name}', [LobbyController::class, 'show'])->middleware(AuthMiddleware::class);



$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
