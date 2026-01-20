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

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo "404 - Page not found";
            return;
        }

        [$controller, $methodAction] = explode('@', $this->routes[$method][$uri]);

        require "./controllers/$controller.php";
        (new $controller)->$methodAction();
    }
}
