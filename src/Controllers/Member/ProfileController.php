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
        if (!isset($_SESSION['id'])) {
            $_SESSION['id'] = 2; // Bypass ID 2
        }

        try {
            $db = DatabaseHelper::getConnection();
            $stmt = $db->prepare("
                SELECT u.username, u.email, u.role, m.* FROM users u 
                JOIN members m ON u.id = m.user_id 
                WHERE u.id = :id
            ");
            $stmt->execute(['id' => $_SESSION['id']]);
            $profileData = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$profileData) {
                die("Data profil tidak ditemukan di database untuk User ID: " . $_SESSION['id']);
            }

            $socialLinks = json_decode($profileData['social_links'] ?? '{}', true);
            require_once __DIR__ . '/../../Views/member-area/profile/index.php';
        } catch (\PDOException $e) {
            die("Kesalahan Database: " . $e->getMessage());
        }
    }

    public function update()
    {
        $this->startSession();
        $userId = 2; // Paksa ID 2 untuk bypass

        // 1. Ambil data dari Form
        $bio    = $_POST['bio'] ?? '';
        $skills = $_POST['skills'] ?? ''; // Tangkap data skills
        $divisi1 = $_POST['divisi1'] ?? '';
        $divisi2 = $_POST['divisi2'] ?? '';

        // Logika Gabung Divisi
        $finalDivisi = $divisi1;
        if ($divisi2 === 'Humas' && $divisi1 !== 'Humas') {
            $finalDivisi = $divisi1 . ', ' . $divisi2;
        }

        // 2. Social Links (JSON)
        $socialLinks = json_encode([
            'github'    => $_POST['github'] ?? '',
            'instagram' => $_POST['instagram'] ?? '',
            'whatsapp'  => $_POST['whatsapp'] ?? ''
        ]);

        // 3. Handle Upload Foto
        $fotoPath = $_POST['old_foto'] ?? '/assets/images/memeng.jpg';
        
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Tentukan folder upload (pastikan folder ini ada di Project Anda)
            $uploadDir = 'assets/images/profiles/';
            
            // Buat folder jika belum ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Buat nama file unik
            $fileName = time() . '_' . $_FILES['foto']['name'];
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destination)) {
                $fotoPath = '/' . $destination; // Simpan path dengan slash awal
            }
        }

        // 4. Proses Update Database
        try {
            $db = DatabaseHelper::getConnection();
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