<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class RecruitmentController
{
    public function index()
    {
        $db = DatabaseHelper::getConnection();

        // 1. Ambil data admin untuk header
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        // 2. Ambil Periode Aktif
        $stmtActive = $db->query("SELECT * FROM recruitment_periods WHERE status = 'Active' LIMIT 1");
        $activePeriod = $stmtActive->fetch(\PDO::FETCH_ASSOC);

        // 3. Hitung Statistik Pelamar untuk Periode Aktif
        $stats = [
            'total' => 0,
            'pending' => 0,
            'accepted' => 0,
            'rejected' => 0,
            'interview' => 0
        ];

        if ($activePeriod) {
            $stmtStats = $db->prepare("
                SELECT status, COUNT(*) as jumlah 
                FROM applicants 
                WHERE period_id = :pid 
                GROUP BY status
            ");
            $stmtStats->execute(['pid' => $activePeriod['id']]);
            foreach ($stmtStats->fetchAll(\PDO::FETCH_ASSOC) as $row) {
                $statusKey = strtolower($row['status']);
                if (array_key_exists($statusKey, $stats)) {
                    $stats[$statusKey] = (int)$row['jumlah'];
                }
            }
            $stats['total'] = array_sum($stats);
        }

        // 4. Ambil 5 Pelamar Terbaru
        $stmtRecent = $db->query("SELECT nama_lengkap, created_at FROM applicants ORDER BY created_at DESC LIMIT 5");
        $recentApplicants = $stmtRecent->fetchAll(\PDO::FETCH_ASSOC);

        // 5. Ambil Semua Periode dengan subquery statistik
        $stmtAll = $db->query("
            SELECT p.*, 
            (SELECT COUNT(*) FROM applicants WHERE period_id = p.id) as total,
            (SELECT COUNT(*) FROM applicants WHERE period_id = p.id AND status = 'Pending') as pending,
            (SELECT COUNT(*) FROM applicants WHERE period_id = p.id AND status = 'Accepted') as accepted
            FROM recruitment_periods p 
            ORDER BY p.tanggal_mulai DESC
        ");
        $allPeriods = $stmtAll->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/recruitment/index.php';
    }

    public function applicants()
    {
        $db = DatabaseHelper::getConnection();
        $periodId = $_GET['id'] ?? null;

        if (!$periodId) {
            header('Location: /admin/recruitment');
            exit;
        }

        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        $stmtP = $db->prepare("SELECT nama_periode FROM recruitment_periods WHERE id = ?");
        $stmtP->execute([$periodId]);
        $period = $stmtP->fetch(\PDO::FETCH_ASSOC);

        if (!$period) die("Periode tidak ditemukan.");

        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';

        $query = "SELECT * FROM applicants WHERE period_id = ?";
        $params = [$periodId];

        if (!empty($search)) {
            $query .= " AND (nama_lengkap ILIKE ? OR nim ILIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        if (!empty($status)) {
            $query .= " AND status = ?";
            $params[] = $status;
        }

        $query .= " ORDER BY created_at DESC";

        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $applicants = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/recruitment/applicants.php';
    }

    public function applicantDetail()
    {
        $db = DatabaseHelper::getConnection();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /admin/recruitment/applicants');
            exit;
        }

        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        $stmt = $db->prepare("
            SELECT a.*, p.nama_periode 
            FROM applicants a 
            JOIN recruitment_periods p ON a.period_id = p.id 
            WHERE a.id = ?
        ");
        $stmt->execute([$id]);
        $applicant = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$applicant) {
            die("Data pelamar tidak ditemukan di database.");
        }

        require_once __DIR__ . '/../../Views/admin/recruitment/applicant-detail.php';
    }

    public function create()
    {
        $db = DatabaseHelper::getConnection();

        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        $stmtDiv = $db->query("SELECT name FROM divisions ORDER BY name ASC");
        $divisions = $stmtDiv->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/recruitment/create.php';
    }

    public function store()
    {
        $db = DatabaseHelper::getConnection();

        // Data Dasar
        $nama = $_POST['nama_periode'] ?? $_POST['recruitment_name'] ?? '';
        $mulai = $_POST['tanggal_mulai'] ?? $_POST['start_date'] ?? null;
        $selesai = $_POST['tanggal_selesai'] ?? $_POST['end_date'] ?? null;
        $status = $_POST['status'] ?? 'Draft';
        $semester = $_POST['semester'] ?? 'Ganjil';
        $tahun = $_POST['tahun_akademik'] ?? date('Y') . '/' . (date('Y') + 1);

        // Data Tambahan (Menangani array dari form)
        $deskripsi = $_POST['description'] ?? '';
        $timeline = isset($_POST['timeline']) ? implode('|', $_POST['timeline']) : '';
        $divisions = isset($_POST['divisions']) ? implode(', ', $_POST['divisions']) : '';

        try {
            if ($status === 'Active') {
                $db->query("UPDATE recruitment_periods SET status = 'Closed' WHERE status = 'Active'");
            }

            $sql = "INSERT INTO recruitment_periods 
                    (nama_periode, tanggal_mulai, tanggal_selesai, status, semester, tahun_akademik, description, timeline, opened_divisions) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $db->prepare($sql);
            $stmt->execute([$nama, $mulai, $selesai, $status, $semester, $tahun, $deskripsi, $timeline, $divisions]);

            header('Location: /admin/recruitment?status=success');
            exit;
        } catch (\Exception $e) {
            die("Gagal menyimpan data: " . $e->getMessage());
        }
    }

    public function edit()
    {
        $db = DatabaseHelper::getConnection();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /admin/recruitment');
            exit;
        }

        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        $stmt = $db->prepare("SELECT * FROM recruitment_periods WHERE id = ?");
        $stmt->execute([$id]);
        $period = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$period) die("Data periode tidak ditemukan.");

        $stmtDiv = $db->query("SELECT name FROM divisions ORDER BY name ASC");
        $divisions = $stmtDiv->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/recruitment/edit.php';
    }

    public function update()
    {
        $db = DatabaseHelper::getConnection();

        $id = $_POST['id'];
        $nama = $_POST['nama_periode'];
        $mulai = $_POST['tanggal_mulai'];
        $selesai = $_POST['tanggal_selesai'];
        $status = $_POST['status'];
        $semester = $_POST['semester'];
        $tahun = $_POST['tahun_akademik'];

        // Data Tambahan
        $deskripsi = $_POST['description'] ?? '';
        $timeline = isset($_POST['timeline']) ? implode('|', $_POST['timeline']) : '';
        $divisions = isset($_POST['divisions']) ? implode(', ', $_POST['divisions']) : '';

        try {
            if ($status === 'Active') {
                $db->query("UPDATE recruitment_periods SET status = 'Closed' WHERE status = 'Active' AND id != $id");
            }

            $sql = "UPDATE recruitment_periods SET 
                    nama_periode = ?, tanggal_mulai = ?, tanggal_selesai = ?, 
                    status = ?, semester = ?, tahun_akademik = ?, 
                    description = ?, timeline = ?, opened_divisions = ?
                    WHERE id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute([$nama, $mulai, $selesai, $status, $semester, $tahun, $deskripsi, $timeline, $divisions, $id]);

            header('Location: /admin/recruitment?status=updated');
            exit;
        } catch (\Exception $e) {
            die("Gagal memperbarui data: " . $e->getMessage());
        }
    }

    // src/Controllers/Admin/RecruitmentController.php

    public function delete()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();
        $id = $_GET['id'] ?? null;

        if ($id) {
            try {
                // Karena tabel applicants menggunakan REFERENCES ... ON DELETE CASCADE,
                // menghapus periode akan otomatis menghapus pelamar di dalamnya.
                $stmt = $db->prepare("DELETE FROM recruitment_periods WHERE id = ?");
                $stmt->execute([$id]);

                header('Location: /admin/recruitment?status=deleted');
                exit;
            } catch (\Exception $e) {
                die("Gagal menghapus data: " . $e->getMessage());
            }
        } else {
            header('Location: /admin/recruitment');
            exit;
        }
    }
}
