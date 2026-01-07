<?php

namespace App\Middlewares;

class GuestMiddleware
{
    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['user_id'])) {
            $role = strtolower($_SESSION['role'] ?? '');
            
            if ($role === 'admin') {
                header('Location: /admin/dashboard');
                exit();
            } elseif ($role === 'anggota') {
                header('Location: /member/dashboard');
                exit();
            }
        }
        
        // Jika belum login, lanjutkan (biarkan akses halaman login)
    }
}