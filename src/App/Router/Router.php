<?php

namespace App\Router;

class Router {
    private array $routes = [];

    public function get(string $uri, callable $callback) {
        return $this->addRoute('GET', $uri, $callback);
    }

    public function post(string $uri, callable $callback) {
        return $this->addRoute('POST', $uri, $callback);
    }

    private function addRoute(string $method, string $uri, callable $callback) {
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
                    if (is_callable([$mw, 'handle'])) {
                        $mw::handle();
                    }
                }

                // collect args in order {id},{other}...
                $args = [];
                foreach ($route->params as $param) {
                    $args[] = $matches[$param] ?? null;
                }


                call_user_func($route->callback, ...$args);
                return;
            }


        }

        http_response_code(404);
        View::errorPage();

        // if (isset($this->routes[$method][$uri])) {
        //     $route = $this->routes[$method][$uri];

        //     foreach ($route->middlewares as $middleware) {
        //         if (is_callable([$middleware, 'handle'])) {
        //             $middleware::handle();
        //         };

        //     }

        //     call_user_func($route->callback);
        // } else {
        //     http_response_code(404);
        //     View::errorPage();
        // }
    }
}
