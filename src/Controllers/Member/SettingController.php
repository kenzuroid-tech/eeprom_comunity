<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class SettingController
{
    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $this->startSession();
        // Mengikuti logic bypass Anda di ProfileController
        if (!isset($_SESSION['id'])) {
            $_SESSION['id'] = 2; 
        }

        try {
            $db = DatabaseHelper::getConnection();
            $stmt = $db->prepare("SELECT username, email FROM users WHERE id = :id");
            $stmt->execute(['id' => $_SESSION['id']]);
            $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$userData) {
                die("User tidak ditemukan.");
            }

            // Memanggil View (Pastikan file view sudah ada)
            require_once __DIR__ . '/../../Views/member-area/profile/index.php';
        } catch (\PDOException $e) {
            die("Kesalahan Database: " . $e->getMessage());
        }
    }

    public function update()
    {
        $this->startSession();
        $userId = $_SESSION['id'] ?? 2; // Bypass sesuai logic Anda

        // 1. Tangkap data dari Form
        $newUsername = $_POST['username'] ?? '';
        $currentPw   = $_POST['current_password'] ?? '';
        $newPw       = $_POST['new_password'] ?? '';
        $confirmPw   = $_POST['confirm_password'] ?? '';

        try {
            $db = DatabaseHelper::getConnection();

            // 2. Ambil password lama untuk verifikasi
            $stmt = $db->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            // 3. Verifikasi Password Saat Ini
            if (!$user || !password_verify($currentPw, $user['password'])) {
                header('Location: /member/profile?status=error&msg=password_salah');
                exit;
            }

            // 4. Cek jika username sudah dipakai orang lain
            $stmtCheck = $db->prepare("SELECT id FROM users WHERE username = :un AND id != :id");
            $stmtCheck->execute(['un' => $newUsername, 'id' => $userId]);
            if ($stmtCheck->fetch()) {
                header('Location: /member/profile?status=error&msg=username_dipakai');
                exit;
            }

            // 5. Siapkan Query Update
            if (!empty($newPw)) {
                // Jika ganti password
                if ($newPw !== $confirmPw) {
                    header('Location: /member/profile?status=error&msg=password_tidak_cocok');
                    exit;
                }
                
                $hashedPw = password_hash($newPw, PASSWORD_BCRYPT);
                $updateStmt = $db->prepare("
                    UPDATE users 
                    SET username = :username, password = :password, updated_at = CURRENT_TIMESTAMP 
                    WHERE id = :id
                ");
                $updateStmt->execute([
                    'username' => $newUsername,
                    'password' => $hashedPw,
                    'id'       => $userId
                ]);
            } else {
                // Jika hanya ganti username
                $updateStmt = $db->prepare("
                    UPDATE users 
                    SET username = :username, updated_at = CURRENT_TIMESTAMP 
                    WHERE id = :id
                ");
                $updateStmt->execute([
                    'username' => $newUsername,
                    'id'       => $userId
                ]);
            }

            header('Location: /member/profile?status=success_account');
            exit;

        } catch (\PDOException $e) {
            die("Gagal memperbarui akun: " . $e->getMessage());
        }
    }
}