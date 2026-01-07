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

        // 1. Ambil data lama untuk pengecekan foto
        $stmtOld = $db->prepare("SELECT foto_url, nim FROM members WHERE user_id = ?");
        $stmtOld->execute([$userId]);
        $oldData = $stmtOld->fetch(\PDO::FETCH_ASSOC);
        
        $fotoPath = $oldData['foto_url'] ?? '/assets/images/memeng.jpg';
        $nim = $oldData['nim'] ?? 'unknown';

        // 2. Ambil data dari Form
        $bio    = $_POST['bio'] ?? '';
        $skills = $_POST['skills'] ?? '';
        $divisi1 = $_POST['divisi1'] ?? '';
        $divisi2 = $_POST['divisi2'] ?? '';

        $finalDivisi = (!empty($divisi2)) ? $divisi1 . ", " . $divisi2 : $divisi1;

        $socialLinks = json_encode([
            'github'    => $_POST['github'] ?? '',
            'instagram' => $_POST['instagram'] ?? '',
            'whatsapp'  => $_POST['whatsapp'] ?? ''
        ]);

        // 3. Handle Upload Foto (Disesuaikan ke folder public/assets/profiles)
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (in_array($_FILES['foto']['type'], $allowedTypes)) {
                
                // Tentukan letak folder public/assets/profiles
                $publicPath = 'assets/profiles/';
                $uploadDir = __DIR__ . '/../../../../public/' . $publicPath; 

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileExtension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $fileName = 'profile_' . $nim . '_' . time() . '.' . $fileExtension;
                $destination = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $destination)) {
                    // Hapus foto lama jika bukan foto default
                    if ($fotoPath !== '/assets/images/memeng.jpg') {
                        $oldFileSystemPath = __DIR__ . '/../../../../public' . $fotoPath;
                        if (file_exists($oldFileSystemPath)) {
                            unlink($oldFileSystemPath);
                        }
                    }
                    // Simpan path yang bisa diakses browser
                    $fotoPath = '/' . $publicPath . $fileName;
                }
            }
        }

        // 4. Proses Update Database
        try {
            $stmt = $db->prepare("
                UPDATE members 
                SET bio = :bio, 
                    skills = :skills,
                    divisi = :divisi, 
                    social_links = :social, 
                    foto_url = :foto, 
                    updated_at = CURRENT_TIMESTAMP
                WHERE user_id = :id
            ");

            $stmt->execute([
                'bio'    => $bio,
                'skills' => $skills,
                'divisi' => $finalDivisi,
                'social' => $socialLinks,
                'foto'   => $fotoPath,
                'id'     => $userId
            ]);

            header('Location: /member/profile?status=success');
            exit;
        } catch (\PDOException $e) {
            die("Gagal simpan ke Database: " . $e->getMessage());
        }
    }
}