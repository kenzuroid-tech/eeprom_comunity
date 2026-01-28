<?php

namespace App\Services\Auth;

use App\Models\User;

class AuthService
{
    private $pdo;
    private $userModel;

    public function __construct()
    {
        $config = require dirname(__DIR__, 3) . '/config/database.php';
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['database']}";

        try {
            $this->pdo = new \PDO($dsn, $config['username'], $config['password']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            error_log("❌ Database connection failed: " . $e->getMessage());
            throw $e;
        }

        $this->userModel = new \App\Models\User($this->pdo);
    }

    public function validateCredentials($identifier, $password)
    {
        $user = $this->userModel->findByIdentifier($identifier);

        if (!$user) return null;

        // Verifikasi password (Bcrypt)
        if (password_verify($password, $user['password'])) {
            return $user;
        }

        // Fallback untuk testing (Hapus jika semua user sudah pakai password_hash)
        if ($password === $user['password']) {
            return $user;
        }

        return null;
    }

    public function login($userData)
    {
        // Lowercase role untuk konsistensi pengecekan
        $role = strtolower($userData['role'] ?? 'anggota');

        $_SESSION['user_id']  = $userData['id'];
        $_SESSION['role']     = $role;
        $_SESSION['nama']     = $userData['nama_lengkap'] ?? $userData['username'];
        $_SESSION['nim']      = $userData['nim'] ?? '';

        $this->userModel->updateLastLogin($userData['id']);
        return true;
    }

    /**
     * Memperbaiki logika redirect agar mengenali Superadmin dan Alumni
     */
    public function getRedirectUrlByRole($role)
    {
        $role = strtolower($role);

        error_log("🚀 AuthService: Redirecting for role -> " . $role);

        switch ($role) {
            case 'superadmin':
            case 'admin':
                return '/admin';

            case 'alumni':
            case 'anggota':
                return '/member/dashboard';

            default:
                error_log("⚠️ Role tidak dikenal: " . $role);
                return '/login';
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
    }
}
