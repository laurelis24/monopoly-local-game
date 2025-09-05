<?php

require_once '../configurations/config.php';
require_once '../src/App/Helpers/abort.php';
use App\Controllers\MainController;
use App\Router\Router;
use App\Controllers\AuthController;
use App\Controllers\LobbyController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;
use App\Session\Session;
use App\Session\SessionHandler;

ini_set('session.gc_maxlifetime', 1800);

$sessionHanlder = new SessionHandler();
Session::setHandler($sessionHanlder, true);
Session::setCookieParams([
    'lifetime' => 0,
    'path' => '/',
    //"secure" => true,
    'httponly' => true,
    'samesite' => 'Strict',
]);
Session::start();
$router = new Router();

// main menu
$router->get('/', [MainController::class, 'index'])->middleware(AuthMiddleware::class);

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
$router->get('/lobby/{id}', [LobbyController::class, 'show'])->middleware(AuthMiddleware::class);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
