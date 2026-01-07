<?php

namespace App\Middlewares;

class AdminMiddleware
{
    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        error_log("🔒 AdminMiddleware: Checking authentication");
        error_log("   Session ID: " . session_id());
        error_log("   Session user_id: " . ($_SESSION['user_id'] ?? 'NOT SET'));
        error_log("   Session role: " . ($_SESSION['role'] ?? 'NOT SET'));
        error_log("   All session data: " . print_r($_SESSION, true));

        // Cek apakah sudah login
        if (!isset($_SESSION['user_id'])) {
            error_log("   ❌ User not logged in, redirecting to /login");
            header('Location: /login');
            exit();
        }

        // Cek apakah role adalah admin (lowercase)
        if ($_SESSION['role'] !== 'admin') {
            error_log("   ❌ Role mismatch. Expected: admin, Got: " . $_SESSION['role']);
            header('Location: /login?error=unauthorized');
            exit();
        }

        error_log("   ✅ Admin authentication passed");
    }
}