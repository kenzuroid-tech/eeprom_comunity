<?php

namespace App\Controllers;

use App\Services\Auth\AuthService;
use App\Helpers\DatabaseHelper;

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
        $success = $_GET['success'] ?? null;
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * AJAX: Mengecek apakah NIM ada di daftar pendaftar yang diterima (Accepted)
     */
    public function checkNim()
    {
        $nim = $_GET['nim'] ?? '';
        $db = DatabaseHelper::getConnection();

        // Cari di tabel members: NIM harus ada, tapi user_id harus NULL (artinya belum punya akun)
        $stmt = $db->prepare("SELECT email, nama_lengkap FROM members WHERE nim = ? AND user_id IS NULL LIMIT 1");
        $stmt->execute([$nim]);
        $member = $stmt->fetch(\PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        if ($member) {
            echo json_encode([
                'success' => true,
                'email' => $member['email'],
                'nama' => $member['nama_lengkap']
            ]);
        } else {
            // Cek apakah sudah punya akun
            $stmtCheck = $db->prepare("SELECT id FROM users WHERE username = ?");
            $stmtCheck->execute([$nim]);
            if ($stmtCheck->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Akun sudah aktif, silakan login.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'NIM tidak terdaftar di database anggota.']);
            }
        }
        exit;
    }

    /**
     * Memproses pendaftaran akun baru
     */
    public function register()
    {
        $nim = $_POST['nim'];
        $password = $_POST['password'];
        $db = \App\Helpers\DatabaseHelper::getConnection();

        try {
            $db->beginTransaction();

            // 1. Ambil data email dari tabel members berdasarkan NIM
            $stmtMember = $db->prepare("SELECT email FROM members WHERE nim = ? AND user_id IS NULL");
            $stmtMember->execute([$nim]);
            $member = $stmtMember->fetch();

            if (!$member) {
                throw new \Exception("NIM tidak valid atau akun sudah aktif.");
            }

            $email = $member['email']; // Ambil email yang sudah ada di tabel members

            // 2. Masukkan ke tabel users (Sinkronisasi Email terjadi di sini)
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmtUser = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'anggota') RETURNING id");
            $stmtUser->execute([$nim, $email, $hashedPassword]);
            $userId = $stmtUser->fetchColumn();

            // 3. Hubungkan user_id ke tabel members
            $stmtUpdate = $db->prepare("UPDATE members SET user_id = ? WHERE nim = ?");
            $stmtUpdate->execute([$userId, $nim]);

            $db->commit();
            header('Location: /login?success=Akun berhasil diaktifkan dengan email: ' . $email);
        } catch (\Exception $e) {
            $db->rollBack();
            header('Location: /register?error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    public function authenticate()
    {
        $identifier = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($identifier) || empty($password)) {
            header('Location: /login?error=empty_fields');
            exit();
        }

        $user = $this->authService->validateCredentials($identifier, $password);

        if (!$user) {
            header('Location: /login?error=invalid_credentials');
            exit();
        }

        $this->authService->login($user);
        $redirectUrl = $this->authService->getRedirectUrlByRole($user['role']);

        header('Location: ' . $redirectUrl);
        exit();
    }

    public function logout()
    {
        $this->authService->logout();
        header('Location: /login');
        exit();
    }

    public function showRegister()
    {
        require_once __DIR__ . '/../Views/auth/register.php';
    }

    public function showForgot()
    {
        require_once __DIR__ . '/../Views/auth/forgot-password.php';
    }
}
