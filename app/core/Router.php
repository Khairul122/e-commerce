<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $pattern, string $handler, array $middleware = []): void
    {
        $this->addRoute('GET', $pattern, $handler, $middleware);
    }

    public function post(string $pattern, string $handler, array $middleware = []): void
    {
        $this->addRoute('POST', $pattern, $handler, $middleware);
    }

    private function addRoute(string $method, string $pattern, string $handler, array $middleware): void
    {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    private function toRegex(string $pattern): string
    {
        $regex = preg_replace('#\{([a-zA-Z_]+)\}#', '(?P<$1>[^/]+)', $pattern);
        return '#^' . $regex . '$#';
    }

    public function dispatch(string $uri, string $method): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        if (defined('BASE_PATH') && BASE_PATH !== '' && str_starts_with($uri, BASE_PATH)) {
            $uri = substr($uri, strlen(BASE_PATH));
        }

        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $regex = $this->toRegex($route['pattern']);
            if (preg_match($regex, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                foreach ($route['middleware'] as $mw) {
                    $this->runMiddleware($mw);
                }

                $this->callHandler($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        $view = APP_PATH . '/views/errors/404.php';
        if (file_exists($view)) {
            include $view;
        } else {
            echo '404 - Halaman tidak ditemukan';
        }
    }

    private function runMiddleware(string $name): void
    {
        if ($name === 'auth') {
            if (empty($_SESSION['user'])) {
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
        } elseif ($name === 'admin') {
            if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
        }
    }

    private function callHandler(string $handler, array $params): void
    {
        [$controllerName, $action] = explode('@', $handler);

        if (str_starts_with($controllerName, 'Admin\\')) {
            $class = 'App\\Controllers\\' . $controllerName;
        } else {
            $class = 'App\\Controllers\\' . $controllerName;
        }

        if (!class_exists($class)) {
            http_response_code(500);
            error_log("Controller class not found: $class");
            die('Terjadi kesalahan pada server.');
        }

        $instance = new $class();

        if (!method_exists($instance, $action)) {
            http_response_code(500);
            error_log("Method not found: $class@$action");
            die('Terjadi kesalahan pada server.');
        }

        call_user_func_array([$instance, $action], $params);
    }
}
