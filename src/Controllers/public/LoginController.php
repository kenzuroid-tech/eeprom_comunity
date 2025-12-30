<?php

namespace App\Controllers;

use App\Services\Auth\AuthService;

class LoginController
{
    private AuthService $authService;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->authService = new AuthService();
    }

    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            $redirectUrl = $this->authService->getRedirectUrlByRole($_SESSION['role']);
            header('Location: ' . $redirectUrl);
            exit();
        }

        $error = $_GET['error'] ?? null;
        require_once __DIR__ . '/../Views/public/auth/login.php';
    }

    public function authenticate()
    {
        error_log("========================================");
        error_log("🔐 LOGIN ATTEMPT STARTED");
        error_log("Time: " . date('Y-m-d H:i:s'));
        error_log("========================================");
        
        $identifier = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        error_log("📝 POST Data Received:");
        error_log("   - Username/Email: " . $identifier);
        error_log("   - Password Length: " . strlen($password));
        error_log("   - Password (first 3 chars): " . substr($password, 0, 3) . "***");

        if (empty($identifier) || empty($password)) {
            error_log("❌ Empty fields detected!");
            header('Location: /login?error=empty_fields');
            exit();
        }

        error_log("🔍 Validating credentials...");
        $user = $this->authService->validateCredentials($identifier, $password);

        if (!$user) {
            error_log("❌ AUTHENTICATION FAILED!");
            error_log("   Reason: Invalid credentials");
            header('Location: /login?error=invalid_credentials');
            exit();
        }

        error_log("✅ AUTHENTICATION SUCCESS!");
        error_log("👤 User Data Retrieved:");
        error_log("   - ID: " . ($user['id'] ?? 'N/A'));
        error_log("   - Username: " . ($user['username'] ?? 'N/A'));
        error_log("   - Email: " . ($user['email'] ?? 'N/A'));
        error_log("   - Role: " . ($user['role'] ?? 'N/A'));
        error_log("   - Nama: " . ($user['nama_lengkap'] ?? 'N/A'));

        error_log("🔐 Creating session...");
        $this->authService->login($user);

        error_log("📦 Session Data After Login:");
        error_log(print_r($_SESSION, true));

        $redirectUrl = $this->authService->getRedirectUrlByRole($user['role']);
        
        error_log("🚀 Redirecting to: " . $redirectUrl);
        error_log("========================================");

        header('Location: ' . $redirectUrl);
        exit();
    }

    public function logout()
    {
        error_log("👋 User logged out: " . ($_SESSION['nama'] ?? 'Unknown'));
        $this->authService->logout();
        header('Location: /login');
        exit();
    }

    public function showRegister()
    {
        require_once __DIR__ . '/../Views/public/auth/register.php';
    }

    public function showForgot()
    {
        require_once __DIR__ . '/../Views/public/auth/forgot-password.php';
    }
}