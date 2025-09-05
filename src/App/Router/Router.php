<?php

namespace App\Router;

use App\Request\Request;

class Router {
    private array $routes = [];

    public function get(string $uri, array $callback) {
        return $this->addRoute('GET', $uri, $callback);
    }

    public function post(string $uri, array $callback) {
        return $this->addRoute('POST', $uri, $callback);
    }

    private function addRoute(string $method, string $uri, array $callback) {
        $route = new Route($method, $uri, $callback);
        $this->routes[$method][] = $route;

        return $route;
    }

    public function dispatch(string $requestUri, string $requestMethod) {
        $uri = rtrim(parse_url($requestUri, PHP_URL_PATH), '/') ?: '/';
        $method = strtoupper($requestMethod);

        foreach ($this->routes[$method] ?? [] as $route) {
            if (preg_match($route->pattern, $uri, $matches)) {
                // run middlewares
                foreach ($route->middlewares as $mw) {
                    if (method_exists($mw, 'handle')) {
                        $mWare = new $mw();
                        $mWare->handle();
                    }

                }

                // collect args in order {id},{other}...
                $args = [];
                foreach ($route->params as $param) {
                    $args[] = $matches[$param] ?? null;
                }

                $controller = new $route->callback[0]();

                $controller->{$route->callback[1]}(new Request(), ...$args);

                return;
            }
        }

        return View::errorPage();
    }
}
