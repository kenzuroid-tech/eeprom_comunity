<?php

namespace App\Helpers;

class DatabaseHelper
{
    public static function getConnection()
    {
        static $pdo = null;
        if ($pdo === null) {
            $config = require __DIR__ . '/../../config/database.php';
            $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['database']};user={$config['username']};password={$config['password']}";
            $pdo = new \PDO($dsn);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return $pdo;
    }
}

class GeneralHelper
{
    public static function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }
}