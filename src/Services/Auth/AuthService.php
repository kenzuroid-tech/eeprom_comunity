<?php

namespace App\Services\Auth;

use App\Models\User;

class AuthService
{
    private $pdo;
    private $userModel;

    public function __construct()
    {
        error_log("🔌 AuthService: Initializing database connection...");
        
        $config = require dirname(__DIR__, 3) . '/config/database.php';
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
        
        error_log("   DSN: " . $dsn);
        
        try {
            $this->pdo = new \PDO($dsn, $config['username'], $config['password']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            error_log("   ✅ Database connected successfully!");
        } catch (\PDOException $e) {
            error_log("   ❌ Database connection failed: " . $e->getMessage());
            throw $e;
        }
        
        $this->userModel = new \App\Models\User($this->pdo);
    }

    public function validateCredentials($identifier, $password)
    {
        error_log("🔐 AuthService: Validating credentials");
        error_log("   Searching for user: " . $identifier);
        
        $user = $this->userModel->findByIdentifier($identifier);
        
        if (!$user) {
            error_log("   ❌ User NOT FOUND in database");
            return null;
        }
        
        error_log("   ✅ User FOUND in database:");
        error_log("      - ID: " . $user['id']);
        error_log("      - Username: " . $user['username']);
        error_log("      - Email: " . $user['email']);
        error_log("      - Role: " . $user['role']);
        error_log("      - Is Active: " . ($user['is_active'] ? 'YES' : 'NO'));
        error_log("      - Password Hash (first 20 chars): " . substr($user['password'], 0, 20) . "...");
        
        // Verifikasi password
        error_log("   🔑 Verifying password...");
        $isPasswordValid = password_verify($password, $user['password']);
        
        error_log("      - Password verify result: " . ($isPasswordValid ? '✅ VALID' : '❌ INVALID'));
        
        if ($isPasswordValid) {
            error_log("   ✅ Credentials validated successfully!");
            return $user;
        }
        
        // Fallback untuk testing (HAPUS DI PRODUCTION!)
        error_log("   ⚠️ Trying plain text comparison (FOR TESTING ONLY)...");
        if ($password === $user['password']) {
            error_log("   ⚠️ Plain text password matched! (INSECURE - Use hashed passwords!)");
            return $user;
        }
        
        error_log("   ❌ Password verification FAILED");
        return null;
    }

    public function login($userData)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        error_log("📦 AuthService: Creating session data");
        
        $_SESSION['user_id']  = $userData['id'];
        $_SESSION['role']     = strtolower($userData['role']); // Pastikan lowercase
        $_SESSION['nama']     = $userData['nama_lengkap'] ?? $userData['username'];
        $_SESSION['nim']      = $userData['nim'] ?? '';
        
        error_log("   Session created:");
        error_log("      - user_id: " . $_SESSION['user_id']);
        error_log("      - role: " . $_SESSION['role']);
        error_log("      - nama: " . $_SESSION['nama']);
        error_log("      - nim: " . $_SESSION['nim']);
        
        $this->userModel->updateLastLogin($userData['id']);
        error_log("   ✅ Last login timestamp updated");
        
        return true;
    }

    public function getRedirectUrlByRole($role)
    {
        $role = strtolower($role);
        
        error_log("🚀 AuthService: Getting redirect URL for role: " . $role);
        
        if ($role === 'admin') {
            error_log("   Redirect URL: /admin");
            return '/admin';
        } elseif ($role === 'anggota') {
            error_log("   Redirect URL: /member/dashboard");
            return '/member/dashboard';
        }
        
        error_log("   ⚠️ Unknown role, redirect to: /login");
        return '/login';
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        error_log("👋 AuthService: Destroying session");
        session_destroy();
    }
}