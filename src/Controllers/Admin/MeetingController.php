<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class MeetingController
{
    // Helper untuk mengambil data admin yang sedang login
    private function getAdminData($db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Gunakan session ID jika ada, jika tidak fallback ke ID 3
        $adminId = $_SESSION['user_id'] ?? 3;

        $stmt = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmt->execute(['id' => $adminId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function index()
    {
        $db = DatabaseHelper::getConnection();

        // 1. Ambil data admin untuk Navbar
        $adminData = $this->getAdminData($db);

        // 2. Ambil semua data rapat (untuk Tab Upcoming & Past)
        $stmt = $db->query("SELECT * FROM meetings ORDER BY date DESC, start_time DESC");
        $meetings = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 3. Ambil daftar anggota (untuk Tab Reports/Dropdown)
        $stmtMembers = $db->query("
        SELECT user_id, nama_lengkap, nim 
        FROM members 
        ORDER BY nama_lengkap ASC
    ");
        $allMembers = $stmtMembers->fetchAll(\PDO::FETCH_ASSOC);

        // 4. Ambil statistik ringkasan (Jika Anda ingin menampilkan angka hadir/izin di Tab Past)
        $querySummaries = "
        SELECT 
            m.id, 
            COUNT(CASE WHEN a.status = 'Hadir' THEN 1 END) as total_hadir
        FROM meetings m
        LEFT JOIN attendance a ON m.id = a.meeting_id
        GROUP BY m.id
    ";
        $stmtSum = $db->query($querySummaries);
        $summaries = $stmtSum->fetchAll(\PDO::FETCH_ASSOC);

        // Kirim semua variabel ke file index.php
        require_once __DIR__ . '/../../Views/admin/meetings/index.php';
    }

    public function create()
    {
        $db = DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);

        require_once __DIR__ . '/../../Views/admin/meetings/create.php';
    }

    public function attendanceInput()
    {
        $db = DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);
        $meetingId = $_GET['id'] ?? null;

        if (!$meetingId) {
            header('Location: /admin/meetings');
            exit;
        }

        $stmtMeeting = $db->prepare("SELECT * FROM meetings WHERE id = ?");
        $stmtMeeting->execute([$meetingId]);
        $meeting = $stmtMeeting->fetch(\PDO::FETCH_ASSOC);

        $stmtAttendance = $db->prepare("
            SELECT 
                u.id as user_id, m.nama_lengkap, m.nim, m.foto_url,
                a.id as attendance_id, a.status, a.remarks
            FROM users u
            JOIN members m ON u.id = m.user_id
            LEFT JOIN attendance a ON u.id = a.user_id AND a.meeting_id = ?
            WHERE u.role = 'anggota' AND u.is_active = TRUE
            ORDER BY m.nama_lengkap ASC
        ");
        $stmtAttendance->execute([$meetingId]);
        $attendanceList = $stmtAttendance->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/attendance/index.php';
    }

    public function attendanceUpdate()
    {
        $db = DatabaseHelper::getConnection();
        $meetingId = $_POST['meeting_id'];
        $attendanceData = $_POST['attendance'] ?? [];

        try {
            $db->beginTransaction();
            foreach ($attendanceData as $data) {
                $status = $data['status'] ?? 'Alpa';
                $remarks = $data['remarks'] ?? '';
                $userId = (int)$data['user_id'];

                $checkStmt = $db->prepare("SELECT id FROM attendance WHERE meeting_id = ? AND user_id = ?");
                $checkStmt->execute([(int)$meetingId, $userId]);
                $existing = $checkStmt->fetch();

                if ($existing) {
                    $updateStmt = $db->prepare("UPDATE attendance SET status = ?, remarks = ? WHERE id = ?");
                    $updateStmt->execute([$status, $remarks, $existing['id']]);
                } else {
                    $insertStmt = $db->prepare("
                        INSERT INTO attendance (meeting_id, user_id, status, remarks, created_at) 
                        VALUES (?, ?, ?, ?, NOW())
                    ");
                    $insertStmt->execute([(int)$meetingId, $userId, $status, $remarks]);
                }
            }
            $db->commit();
            header("Location: /admin/attendance/input?id=$meetingId&status=success");
            exit;
        } catch (\Exception $e) {
            $db->rollBack();
            die("Gagal simpan absensi: " . $e->getMessage());
        }
    }

    public function attendanceSummary()
    {
        $db = DatabaseHelper::getConnection();

        // Ambil data admin untuk navbar
        $adminData = $this->getAdminData($db);

        // Query rekap absensi per rapat
        $querySummaries = "
            SELECT 
                m.id, m.title, m.date, m.location,
                COUNT(CASE WHEN a.status = 'Hadir' THEN 1 END) as total_hadir,
                COUNT(CASE WHEN a.status = 'Izin' THEN 1 END) as total_izin,
                COUNT(CASE WHEN a.status = 'Alpa' THEN 1 END) as total_alpa
            FROM meetings m
            LEFT JOIN attendance a ON m.id = a.meeting_id
            GROUP BY m.id, m.title, m.date, m.location
            ORDER BY m.date DESC
        ";
        $stmtSummaries = $db->query($querySummaries);
        $summaries = $stmtSummaries->fetchAll(\PDO::FETCH_ASSOC);

        // Query daftar anggota untuk dropdown Export Report
        $stmtMembers = $db->query("
            SELECT user_id, nama_lengkap, nim 
            FROM members 
            ORDER BY nama_lengkap ASC
        ");
        $allMembers = $stmtMembers->fetchAll(\PDO::FETCH_ASSOC);

        // Pastikan memanggil file summary.php, bukan index.php
        require_once __DIR__ . '/../../Views/admin/attendance/summary.php';
    }

    public function notulensi()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();

        // Ambil data admin untuk navbar profil
        if (session_status() === PHP_SESSION_NONE) session_start();
        $adminId = $_SESSION['user_id'] ?? null;
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmtAdmin->execute(['id' => $adminId]);
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        // Ambil daftar rapat yang sudah memiliki isi notulensi
        // Asumsi: Anda memiliki kolom 'notulensi' atau tabel 'meeting_notes'
        $stmt = $db->query("SELECT id, title, date, location, notulensi FROM meetings WHERE notulensi IS NOT NULL ORDER BY date DESC");
        $meetings = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/meetings/notulensi.php';
    }

    public function scan($id = null)
    {
        try {
            $db = DatabaseHelper::getConnection();

            // FIX: Jika $id kosong dari Router, coba ambil dari $_GET['mtg_id']
            if (!$id && isset($_GET['mtg_id'])) {
                $id = $_GET['mtg_id'];
            }

            // 1. Jika ID tetap tidak ada, ambil rapat terbaru hari ini
            if (!$id) {
                $stmt = $db->query("SELECT id FROM meetings WHERE date = CURRENT_DATE LIMIT 1");
                $meetingId = $stmt->fetchColumn();

                if (!$meetingId) {
                    die("Tidak ada jadwal rapat untuk hari ini. Silakan gunakan link spesifik.");
                }
                $id = $meetingId;
            }

            // 2. Ambil detail informasi rapat
            $stmtMeeting = $db->prepare("SELECT * FROM meetings WHERE id = ?");
            $stmtMeeting->execute([$id]);
            $meeting = $stmtMeeting->fetch(\PDO::FETCH_ASSOC);

            if (!$meeting) {
                die("Data rapat tidak ditemukan.");
            }

            // 3. Ambil daftar anggota aktif untuk dropdown di view
            $stmtMembers = $db->query("SELECT user_id, nama_lengkap, nim FROM members WHERE status_keanggotaan = 'Active' ORDER BY nama_lengkap ASC");
            $members = $stmtMembers->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/admin/attendance/scan.php';
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function store()
    {
        $db = DatabaseHelper::getConnection();

        // Ambil data dari $_POST (karena form HTML biasa)
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $date = $_POST['date'] ?? null;
        $start_time = $_POST['start_time'] ?? null;
        $location = $_POST['location'] ?? '';

        try {
            $stmt = $db->prepare("INSERT INTO meetings (title, description, date, start_time, location) VALUES (?, ?, ?, ?, ?)");

            // PERBAIKAN: Ganti titik (.) menjadi panah (->)
            $stmt->execute([$title, $description, $date, $start_time, $location]);

            header('Location: /admin/meetings?status=success');
            exit;
        } catch (\Exception $e) {
            die("Gagal menyimpan rapat: " . $e->getMessage());
        }
    }

    public function createNotulensi()
    {
        $id = $_GET['id'] ?? null;
        $db = \App\Helpers\DatabaseHelper::getConnection();

        // Ambil data rapat untuk referensi di halaman pengisian
        $stmt = $db->prepare("SELECT * FROM meetings WHERE id = ?");
        $stmt->execute([$id]);
        $meeting = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$meeting) {
            die("Rapat tidak ditemukan.");
        }

        require_once dirname(__DIR__, 2) . '/Views/admin/meetings/create_notulensi.php';
    }

    public function storeNotulensi()
    {
        $id = $_POST['id'];
        $notulensi = $_POST['notulensi'];

        $db = \App\Helpers\DatabaseHelper::getConnection();

        // Update kolom notulensi pada tabel meetings
        $stmt = $db->prepare("UPDATE meetings SET notulensi = ? WHERE id = ?");
        $stmt->execute([$notulensi, $id]);

        header('Location: /admin/meetings/notulensi?status=success');
        exit;
    }
}
