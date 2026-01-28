<?php

namespace App\Middlewares;

class AdminMiddleware
{
    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Cek apakah sudah login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // 2. Daftar role yang diizinkan masuk ke area Admin
        $allowedRoles = ['admin', 'superadmin'];

        // 3. Cek apakah role user ada di dalam daftar yang diizinkan
        if (!in_array($_SESSION['role'], $allowedRoles)) {
            error_log(" ❌ Access Denied for role: " . $_SESSION['role']);
            header('Location: /login?error=unauthorized');
            exit();
        }

        error_log(" ✅ Access Granted for role: " . $_SESSION['role']);
    }
}
