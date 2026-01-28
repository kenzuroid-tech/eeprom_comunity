<?php
// config/connection.php

// Gunakan __DIR__ untuk path yang lebih akurat
$configFile = __DIR__ . '/database.php';

// Load konfigurasi (gunakan include agar bisa load ulang jika perlu)
$config = include $configFile;

// Debug: cek apakah $config adalah array
if (!is_array($config)) {
    die("Error: File database.php tidak mengembalikan array konfigurasi");
}

// Buat connection string
$connection_string = sprintf(
    "host=%s port=%d dbname=%s user=%s password=%s",
    $config['host'],
    $config['port'],
    $config['database'],
    $config['username'],
    $config['password']
);

// Buat koneksi
$conn = pg_connect($connection_string);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . pg_last_error());
}

return $conn;