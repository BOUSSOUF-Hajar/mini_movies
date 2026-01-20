<?php

class Router {

    private array $routes = [];

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch() {

    $method = $_SERVER['REQUEST_METHOD'];
    $uri = trim($_GET['url'] ?? '', '/');

    foreach ($this->routes[$method] ?? [] as $route => $action) {

        if (preg_match("#^$route$#", $uri, $matches)) {

            array_shift($matches);

            [$controller, $methodAction] = explode('@', $action);

            require "./controllers/$controller.php";
            (new $controller)->$methodAction(...$matches);
            return;
        }
    }

    http_response_code(404);
    echo '404 - Page not found';
}

}
