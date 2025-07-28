<?php

namespace App\Router;

interface IRoute {
    public string $method {get;}
    public string $uri {get;}
    public $callback {get;}
    public array $middlewares {get;}
    public array $params {get;}
}

class Route implements IRoute {
    public string $method;
    public string $uri;
    public $callback;
    public array $middlewares = [];

    public string $pattern;
    public array $params = [];

    public function __construct(string $method, string $uri, callable|array $callback) {
        $this->method = $method;
        $this->uri = $uri;
        $this->callback = $callback;

        [$pattern, $params] = $this->compile($uri);
        $this->pattern = $pattern;
        $this->params = $params;

        return $this;
    }


    public function middleware(string|array $middleware) {
        $this->middlewares = array_merge($this->middlewares, (array)$middleware);
    }

    private function compile(string $uri): array {
        $params = [];

        $pattern = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            function ($m) use (&$params) {
                $params[] = $m[1];
                return '(?P<' . $m[1] . '>[^/]+)'; // default: anything but slash
            },
            $uri
        );

        // anchor, allow optional trailing slash
        $pattern = '#^' . rtrim($pattern, '/') . '/?$#';

        return [$pattern, $params];
    }
}
