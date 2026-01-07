<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class AnnouncementController
{
    // Helper untuk memastikan user login dan mengambil ID
    private function getLoggedInUserId()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        return $_SESSION['user_id'];
    }

    public function index()
    {
        $userId = $this->getLoggedInUserId();

        try {
            $db = DatabaseHelper::getConnection();

            // 1. Ambil data user untuk Navbar
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // Variabel untuk sinkronisasi View Navbar
            $fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';

            // 2. Ambil data pengumuman terbaru
            $stmtAnn = $db->query("SELECT * FROM announcements ORDER BY created_at DESC");
            $announcements = $stmtAnn->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/member-area/announcements/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }

    public function detail()
    {
        $userId = $this->getLoggedInUserId();
        $id = $_GET['id'] ?? null;

        // Jika ID tidak ada, kembalikan ke daftar pengumuman
        if (!$id) {
            header('Location: /member/announcements');
            exit;
        }

        try {
            $db = \App\Helpers\DatabaseHelper::getConnection();

            // 1. Ambil data detail pengumuman berdasarkan ID
            $stmt = $db->prepare("SELECT * FROM announcements WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $announcement = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$announcement) {
                die("Pengumuman tidak ditemukan.");
            }

            // 2. Ambil data user untuk navbar (Dinamis dari Session)
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            $userFoto = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';

            // Load file view detail
            require_once __DIR__ . '/../../Views/member-area/announcements/detail.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }
}
