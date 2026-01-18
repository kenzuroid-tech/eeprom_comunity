<?php

namespace App;

class Router
{
    protected $routes = [];
    protected $lastRoute = null; // Track last route yang di-register

    public function get($path, $controller, $method)
    {
        $this->routes['GET'][$path] = [
            'controller' => $controller,
            'method' => $method,
            'middleware' => []
        ];
        
        // Set reference ke route ini
        $this->lastRoute = &$this->routes['GET'][$path];
        
        error_log("📝 Route registered: GET $path -> $controller::$method");
        return $this;
    }

    public function post($path, $controller, $method)
    {
        $this->routes['POST'][$path] = [
            'controller' => $controller,
            'method' => $method,
            'middleware' => []
        ];
        
        // Set reference ke route ini
        $this->lastRoute = &$this->routes['POST'][$path];
        
        error_log("📝 Route registered: POST $path -> $controller::$method");
        return $this;
    }

    public function middleware($middlewareClass)
    {
        if ($this->lastRoute !== null) {
            $this->lastRoute['middleware'][] = $middlewareClass;
            error_log("   🔒 Middleware added: $middlewareClass");
        }
        
        return $this;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        error_log("========================================");
        error_log("🔍 Router Dispatch");
        error_log("   Method: $method");
        error_log("   Path: $path");
        error_log("   POST Data: " . print_r($_POST, true));

        // Skip file statis
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $path) && is_file($_SERVER['DOCUMENT_ROOT'] . $path)) {
            error_log("⏭️  Static file detected");
            return false;
        }

        // Normalize path
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        error_log("🗺️  Normalized path: $path");

        if (isset($this->routes[$method][$path])) {
            $route = $this->routes[$method][$path];
            
            error_log("✅ Route MATCHED!");
            error_log("   Controller: " . $route['controller']);
            error_log("   Method: " . $route['method']);
            error_log("   Middleware count: " . count($route['middleware']));

            // Eksekusi Middleware
            if (!empty($route['middleware'])) {
                error_log("🔒 Running middleware:");
                foreach ($route['middleware'] as $mw) {
                    error_log("   - " . $mw);
                    (new $mw())->handle();
                }
            } else {
                error_log("ℹ️  No middleware");
            }

            // Panggil Controller
            error_log("🎯 Executing controller...");
            $controller = new $route['controller']();
            $methodName = $route['method'];
            $controller->$methodName();
            
            error_log("✅ Done");
            error_log("========================================");
            return;
        }

        error_log("❌ Route NOT FOUND");
        error_log("========================================");
        
        http_response_code(404);
        echo "404 - Not Found: $method $path";
    }
}