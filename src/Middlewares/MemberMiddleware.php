<?php

namespace App\Middlewares;

class MemberMiddleware
{
    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // PERBAIKAN: Pastikan mengecek 'anggota' (kecil), bukan 'Anggota'
        if ($_SESSION['role'] !== 'anggota') {
            header('Location: /login?error=unauthorized');
            exit();
        }
    }
}