<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class AttendanceController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userId = 2; // Bypass ID 2 sementara

        try {
            $db = DatabaseHelper::getConnection();

            // 1. Ambil data User untuk Header
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // 2. Ambil Statistik Kehadiran
            $stmtStats = $db->prepare("
                SELECT 
                    COUNT(*) as total_pertemuan,
                    COUNT(CASE WHEN status = 'Hadir' THEN 1 END) as total_hadir,
                    COUNT(CASE WHEN status = 'Tidak Hadir' THEN 1 END) as total_alpa
                FROM attendance WHERE user_id = :id
            ");
            $stmtStats->execute(['id' => $userId]);
            $stats = $stmtStats->fetch(\PDO::FETCH_ASSOC);

            // 3. Ambil Daftar Riwayat Kehadiran (JOIN dengan tabel meetings)
            // Cari bagian ini di AttendanceController.php
            $stmtList = $db->prepare("
                SELECT m.title, m.date, m.start_time, m.location, a.status, a.remarks 
                FROM attendance a
                JOIN meetings m ON a.meeting_id = m.id
                WHERE a.user_id = :id
                ORDER BY m.date DESC, m.start_time DESC
            ");
            // Ubah 'time' menjadi 'start_time'
            $stmtList->execute(['id' => $userId]);
            $attendanceRecords = $stmtList->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/member-area/attendance/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }
}
