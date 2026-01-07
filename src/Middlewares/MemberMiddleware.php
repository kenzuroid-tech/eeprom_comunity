<?php

namespace App\Middlewares;

class MemberMiddleware
{
    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        error_log("🔒 MemberMiddleware: Checking authentication");
        error_log("   Session ID: " . session_id());
        error_log("   Session user_id: " . ($_SESSION['user_id'] ?? 'NOT SET'));
        error_log("   Session role: " . ($_SESSION['role'] ?? 'NOT SET'));
        error_log("   All session data: " . print_r($_SESSION, true));

        if (!isset($_SESSION['user_id'])) {
            error_log("   ❌ User not logged in, redirecting to /login");
            header('Location: /login');
            exit();
        }

        // PERBAIKAN: Pastikan mengecek 'anggota' (kecil), bukan 'Anggota'
        if ($_SESSION['role'] !== 'anggota') {
            error_log("   ❌ Role mismatch. Expected: anggota, Got: " . $_SESSION['role']);
            header('Location: /login?error=unauthorized');
            exit();
        }

        error_log("   ✅ Member authentication passed");
    }
}