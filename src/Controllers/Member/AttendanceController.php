<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class AttendanceController
{
    public function index()
    {
        // 1. Proteksi Sesi & Login
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah user sudah login, jika belum lempar ke login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        try {
            $db = DatabaseHelper::getConnection();

            // 2. Ambil Profil User (Gunakan FETCH_ASSOC secara eksplisit)
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // Jika data member tidak ditemukan (misal: user id ada di tabel users tapi belum ada di members)
            if (!$userData) {
                $userData = [
                    'nama_lengkap' => 'Member EEPROM',
                    'foto_url' => null
                ];
            }

            // Path foto untuk view (pastikan sesuai dengan logika navbar Anda)
            $fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';

            // 3. Ambil Statistik Kehadiran
            // Optimasi: Memastikan nilai default 0 jika data kosong
            $stmtStats = $db->prepare("
                SELECT 
                    COUNT(*) as total_pertemuan,
                    COUNT(CASE WHEN status = 'Hadir' THEN 1 END) as total_hadir,
                    COUNT(CASE WHEN status = 'Tidak Hadir' THEN 1 END) as total_alpa
                FROM attendance 
                WHERE user_id = :id
            ");
            $stmtStats->execute(['id' => $userId]);
            $stats = $stmtStats->fetch(\PDO::FETCH_ASSOC);

            // Inisialisasi default stats jika record belum ada sama sekali
            if (!$stats) {
                $stats = ['total_pertemuan' => 0, 'total_hadir' => 0, 'total_alpa' => 0];
            }

            // 4. Ambil Riwayat Kehadiran (JOIN dengan tabel meetings)
            // Tambahkan kolom 'id' meeting jika diperlukan untuk link detail nantinya
            $stmtList = $db->prepare("
                SELECT m.title, m.date, m.start_time, m.location, a.status, a.remarks 
                FROM attendance a
                JOIN meetings m ON a.meeting_id = m.id
                WHERE a.user_id = :id
                ORDER BY m.date DESC, m.start_time DESC
            ");
            $stmtList->execute(['id' => $userId]);
            $attendanceRecords = $stmtList->fetchAll(\PDO::FETCH_ASSOC);

            // 5. Kirim data ke View
            // Variabel yang tersedia di view: $userData, $fotoPath, $stats, $attendanceRecords
            require_once __DIR__ . '/../../Views/member-area/attendance/index.php';
        } catch (\PDOException $e) {
            // Log error ke file (jangan tampilkan detail DB ke user di production)
            error_log("Attendance Error: " . $e->getMessage());
            die("Maaf, terjadi kendala teknis saat mengambil data kehadiran.");
        }
    }
}
