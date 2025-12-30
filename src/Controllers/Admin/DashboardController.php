<?php

namespace App\Controllers\Admin; // Harus sama dengan folder: Controllers/Admin

use App\Helpers\DatabaseHelper;

class DashboardController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = 3; // ID Admin (Nisho Admin)

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

            // Pastikan path view ini benar
            require_once __DIR__ . '/../../Views/admin/dashboard.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }
}
