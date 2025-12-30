<?php
namespace App\Middlewares;

class AuthMiddleware
{
    public static function checkLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public static function checkRole($requiredRole)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
            header('Location: /login?error=unauthorized');
            exit();
        }
    }
}