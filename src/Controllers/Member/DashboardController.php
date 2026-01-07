<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class DashboardController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Ambil ID User dari session login
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $db = \App\Helpers\DatabaseHelper::getConnection();

        // 1. Ambil data dasar member (Nama & Foto)
        $stmt = $db->prepare("SELECT nama_lengkap, foto_url, created_at FROM members WHERE user_id = :id");
        $stmt->execute(['id' => $userId]);
        $member = $stmt->fetch(\PDO::FETCH_ASSOC);

        // 2. Hitung Statistik Kehadiran
        $stmtAtt = $db->prepare("
        SELECT 
            COUNT(*) as total_pertemuan,
            COUNT(CASE WHEN status = 'Hadir' THEN 1 END) as total_hadir
        FROM attendance WHERE user_id = :id
    ");
        $stmtAtt->execute(['id' => $userId]);
        $att = $stmtAtt->fetch(\PDO::FETCH_ASSOC);

        $totalMeetings = (int)$att['total_pertemuan'];
        $totalHadir = (int)$att['total_hadir'];
        $attendancePercent = ($totalMeetings > 0) ? round(($totalHadir / $totalMeetings) * 100) : 0;

        // 3. Cek Status Voting
        $stmtVote = $db->prepare("SELECT id FROM votes WHERE user_id = :id");
        $stmtVote->execute(['id' => $userId]);
        $hasVoted = $stmtVote->fetch();

        // 4. Susun data untuk dikirim ke View
        $dashboardData = [
            'nama'           => $member['nama_lengkap'],
            'foto'           => !empty($member['foto_url']) ? $member['foto_url'] : '/assets/images/default-avatar.png',
            'attendance'     => $attendancePercent,
            'total_meetings' => $totalMeetings,
            'voting_status'  => $hasVoted ? 'Sudah Memilih' : 'Belum Memilih',
            'active_since'   => date('F Y', strtotime($member['created_at']))
        ];

        require_once __DIR__ . '/../../Views/member-area/dashboard.php';
    }
}
