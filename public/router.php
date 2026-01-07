<?php
// public/router.php

// Handle static files FIRST - sebelum load apapun
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Daftar ekstensi static files
$extensions = ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot', 'otf', 'map', 'webp'];

// Get file extension
$ext = strtolower(pathinfo($uri, PATHINFO_EXTENSION));

// If it's a static file
if (in_array($ext, $extensions)) {
    $file = __DIR__ . $uri;
    
    if (file_exists($file) && is_file($file)) {
        // Let PHP serve the file directly
        return false;
    } else {
        // File not found
        http_response_code(404);
        echo "404 - File not found: $uri";
        exit;
    }
}

// Not a static file, load index.php
require __DIR__ . '/index.php';