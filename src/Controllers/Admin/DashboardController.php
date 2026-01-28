<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class DashboardController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? 3; // Mengambil ID dari session jika ada

        try {
            $db = DatabaseHelper::getConnection();

            // 1. Data User Admin
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $adminData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // 2. Statistik Card
            $totalAnggota = $db->query("SELECT COUNT(*) FROM members")->fetchColumn();
            $totalKegiatan = $db->query("SELECT COUNT(*) FROM meetings")->fetchColumn();
            $totalAnnouncements = $db->query("SELECT COUNT(*) FROM announcements")->fetchColumn();
            $totalVotes = $db->query("SELECT COUNT(*) FROM votes")->fetchColumn();

            // 3. Data Grafik
            $stmtChart = $db->query("
                SELECT m.title, COUNT(a.id) as hadir 
                FROM meetings m 
                LEFT JOIN attendance a ON m.id = a.meeting_id AND a.status = 'Hadir'
                GROUP BY m.id, m.title ORDER BY m.date DESC LIMIT 5
            ");
            $chartData = array_reverse($stmtChart->fetchAll(\PDO::FETCH_ASSOC));

            // --- TAMBAHAN BARU: SISTEM LOG AKTIVITAS NYATA ---
            // Mengambil 5 aktivitas terbaru dari pendaftar, forum, dan pengumuman
            $stmtLogs = $db->query("
                (SELECT 'Pendaftar Baru: ' || nama_lengkap as msg, created_at, 'success' as color FROM applicants)
                UNION ALL
                (SELECT 'Forum Baru: ' || title as msg, created_at, 'primary' as color FROM forum_posts)
                UNION ALL
                (SELECT 'Pengumuman: ' || title as msg, created_at, 'warning' as color FROM announcements)
                ORDER BY created_at DESC LIMIT 5
            ");
            $logs = $stmtLogs->fetchAll(\PDO::FETCH_ASSOC);

            // Pastikan path view ini benar
            require_once __DIR__ . '/../../Views/admin/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }
}