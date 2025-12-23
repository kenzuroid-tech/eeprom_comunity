<?php
// Simple routing
$request = $_SERVER['REQUEST_URI'];

if ($request === '/' || $request === '/member/home') {
    require_once '../src/Controllers/HomeController.php';
    $controller = new Controllers\HomeController();
    $controller->index();
} else {
    // Handle other routes or 404
    echo "404 Not Found";
}
?>