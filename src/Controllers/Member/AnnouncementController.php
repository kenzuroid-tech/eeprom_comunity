<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class AnnouncementController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userId = 2; // Bypass sementara

        try {
            $db = DatabaseHelper::getConnection();

            // Ambil data user untuk navbar
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // Ambil data pengumuman terbaru
            $stmtAnn = $db->query("SELECT * FROM announcements ORDER BY created_at DESC");
            $announcements = $stmtAnn->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/member-area/announcements/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }

    public function detail()
    {
        $id = $_GET['id'] ?? null;

        // Jika ID tidak ada, kembalikan ke daftar pengumuman
        if (!$id) {
            header('Location: /member/announcements');
            exit;
        }

        $db = \App\Helpers\DatabaseHelper::getConnection();

        // Ambil data detail pengumuman berdasarkan ID
        $stmt = $db->prepare("SELECT * FROM announcements WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $announcement = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Ambil data user untuk navbar (Bypass ID 2)
        $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 2");
        $stmtUser->execute();
        $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

        // Load file view detail
        require_once __DIR__ . '/../../Views/member-area/announcements/detail.php';
    }
}
