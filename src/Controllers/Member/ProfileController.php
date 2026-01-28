<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class ProfileController
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

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        try {
            $db = DatabaseHelper::getConnection();
            $stmt = $db->prepare("
                SELECT u.username, u.email, u.role, m.* FROM users u 
                JOIN members m ON u.id = m.user_id 
                WHERE u.id = :id
            ");
            $stmt->execute(['id' => $_SESSION['user_id']]);
            $profileData = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$profileData) {
                die("Data profil tidak ditemukan.");
            }

            // Definisikan fotoPath agar bisa digunakan di View Navbar & Profile
            $fotoPath = !empty($profileData['foto_url']) ? $profileData['foto_url'] : '/assets/images/memeng.jpg';

            $socialLinks = json_decode($profileData['social_links'] ?? '{}', true);

            require_once __DIR__ . '/../../Views/member-area/profile/index.php';
        } catch (\PDOException $e) {
            die("Kesalahan Database: " . $e->getMessage());
        }
    }

    public function update()
    {
        $this->startSession();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $db = DatabaseHelper::getConnection();

        // 1. Ambil data lama untuk foto
        $stmtOld = $db->prepare("SELECT foto_url, nim, email FROM members WHERE user_id = ?");
        $stmtOld->execute([$userId]);
        $oldData = $stmtOld->fetch(\PDO::FETCH_ASSOC);

        $fotoPath = $oldData['foto_url'] ?? '/assets/images/memeng.jpg';
        $newEmail = $_POST['email'] ?? $oldData['email']; // Ambil email baru dari form

        // 2. Handle Upload Foto (Gunakan logic yang sudah diperbaiki sebelumnya)
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = dirname(__DIR__, 3) . '/public/assets/profiles/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileExtension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $fileName = 'profile_' . ($oldData['nim'] ?? 'user') . '_' . time() . '.' . $fileExtension;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $fileName)) {
                if (!empty($oldData['foto_url']) && strpos($oldData['foto_url'], 'memeng.jpg') === false) {
                    $oldFile = dirname(__DIR__, 3) . '/public' . $oldData['foto_url'];
                    if (file_exists($oldFile)) unlink($oldFile);
                }
                $fotoPath = '/assets/profiles/' . $fileName;
            }
        }

        // 3. Update Database (Gunakan Transaction)
        try {
            $db->beginTransaction();

            // Update Tabel Members
            $stmtMember = $db->prepare("
            UPDATE members 
            SET email = :email,
                bio = :bio, 
                skills = :skills,
                divisi = :divisi, 
                social_links = :social, 
                foto_url = :foto, 
                updated_at = CURRENT_TIMESTAMP
            WHERE user_id = :id
        ");

            $stmtMember->execute([
                'email'  => $newEmail,
                'bio'    => $_POST['bio'] ?? '',
                'skills' => $_POST['skills'] ?? '',
                'divisi' => (!empty($_POST['divisi2'])) ? $_POST['divisi1'] . ", " . $_POST['divisi2'] : $_POST['divisi1'],
                'social' => json_encode([
                    'github'    => $_POST['github'] ?? '',
                    'instagram' => $_POST['instagram'] ?? '',
                    'whatsapp'  => $_POST['whatsapp'] ?? ''
                ]),
                'foto'   => $fotoPath,
                'id'     => $userId
            ]);

            // Update Tabel Users (SINKRONISASI EMAIL)
            $stmtUser = $db->prepare("UPDATE users SET email = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmtUser->execute([$newEmail, $userId]);

            $db->commit();
            header('Location: /member/profile?status=success');
            exit;
        } catch (\Exception $e) {
            if ($db->inTransaction()) $db->rollBack();
            die("Gagal memperbarui profil: " . $e->getMessage());
        }
    }
}
