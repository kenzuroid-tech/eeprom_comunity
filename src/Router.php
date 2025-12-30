<?php

namespace App;

class Router
{
    protected $routes = [];
    protected $middleware = [];

    public function get($path, $controller, $method)
    {
        $this->routes['GET'][$path] = [
            'controller' => $controller,
            'method' => $method
        ];
        return $this;
    }

    public function post($path, $controller, $method)
    {
        $this->routes['POST'][$path] = [
            'controller' => $controller,
            'method' => $method
        ];
        error_log("📝 Route registered: POST $path -> $controller::$method");
        return $this;
    }

    public function middleware($middlewareClass)
    {
        $lastMethod = array_key_last($this->routes);
        $lastPath = array_key_last($this->routes[$lastMethod]);
        $this->routes[$lastMethod][$lastPath]['middleware'][] = $middlewareClass;
        return $this;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        error_log("🔍 Router: $method $path");

        // Skip file statis
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $path) && is_file($_SERVER['DOCUMENT_ROOT'] . $path)) {
            return false;
        }

        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        error_log("🗺️  Looking for route: $method $path");
        error_log("📋 Available routes: " . print_r(array_keys($this->routes[$method] ?? []), true));

        if (isset($this->routes[$method][$path])) {
            $route = $this->routes[$method][$path];
            
            error_log("✅ Route found! Controller: " . $route['controller'] . ", Method: " . $route['method']);

            // Eksekusi Middleware
            if (isset($route['middleware'])) {
                error_log("🔒 Running middleware...");
                foreach ($route['middleware'] as $mw) {
                    error_log("   - " . $mw);
                    (new $mw())->handle();
                }
            }

            // Panggil Controller
            error_log("🎯 Executing controller...");
            $controller = new $route['controller']();
            $methodName = $route['method'];
            return $controller->$methodName();
        }

        // Route tidak ditemukan
        error_log("❌ Route NOT FOUND: $method $path");
        http_response_code(404);
        echo "404 - Halaman Tidak Ditemukan<br>";
        echo "Requested: $method $path<br>";
        echo "<pre>Available routes:\n";
        print_r($this->routes);
        echo "</pre>";
    }
}