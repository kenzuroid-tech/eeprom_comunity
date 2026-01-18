<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class VotingController
{
    private function getAdminData($db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $adminId = $_SESSION['user_id'] ?? 3;
        $stmt = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmt->execute(['id' => $adminId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function index()
    {
        $db = DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);

        // Ambil sesi pemilihan yang paling baru/aktif
        $stmtActive = $db->query("SELECT * FROM elections ORDER BY created_at DESC LIMIT 1");
        $activeElection = $stmtActive->fetch(\PDO::FETCH_ASSOC);

        $results = [];
        $totalVotes = 0;
        $totalMembers = 0;

        if ($activeElection) {
            $electionId = $activeElection['id'];
            // Hitung statistik khusus untuk sesi ini
            $totalMembers = $db->query("SELECT COUNT(*) FROM users WHERE role = 'anggota'")->fetchColumn();
            $totalVotes = $db->prepare("SELECT COUNT(*) FROM votes WHERE election_id = ?");
            $totalVotes->execute([$electionId]);
            $totalVotes = $totalVotes->fetchColumn();

            $stmtStats = $db->prepare("
                SELECT c.*, COUNT(v.id) as total_votes
                FROM candidates c
                LEFT JOIN votes v ON c.id = v.candidate_id AND v.election_id = ?
                WHERE c.election_id = ?
                GROUP BY c.id ORDER BY c.number_order ASC
            ");
            $stmtStats->execute([$electionId, $electionId]);
            $results = $stmtStats->fetchAll(\PDO::FETCH_ASSOC);
        }

        require_once __DIR__ . '/../../Views/admin/voting/index.php';
    }

    public function resetVotes()
    {
        // 1. Inisialisasi Database
        $db = \App\Helpers\DatabaseHelper::getConnection();

        try {
            // 2. Gunakan TRUNCATE untuk menghapus semua isi tabel votes dengan cepat
            // RESTART IDENTITY akan mengembalikan ID urutan ke angka 1 lagi
            $db->exec("TRUNCATE TABLE votes RESTART IDENTITY");

            // 3. Redirect kembali ke dashboard voting dengan pesan sukses
            header('Location: /admin/voting?status=reset_success');
            exit;
        } catch (\PDOException $e) {
            // Jika gagal, tampilkan error
            die("Gagal mereset data voting: " . $e->getMessage());
        }
    }

    public function candidates()
    {
        $db = DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);

        // Ambil sesi pemilihan terbaru
        $stmtActive = $db->query("SELECT id, title FROM elections ORDER BY created_at DESC LIMIT 1");
        $activeElection = $stmtActive->fetch(\PDO::FETCH_ASSOC);

        if (!$activeElection) {
            header('Location: /admin/voting/create?msg=must_create_election');
            exit;
        }

        $stmt = $db->prepare("SELECT * FROM candidates WHERE election_id = ? ORDER BY number_order ASC");
        $stmt->execute([$activeElection['id']]);
        $candidates = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $allMembers = $db->query("SELECT user_id, nama_lengkap, nim, divisi FROM members ORDER BY nama_lengkap ASC")->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/voting/candidates.php';
    }

    public function deleteCandidate()
    {
        // 1. Ambil ID dari URL (?id=...)
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /admin/voting/candidates?status=error');
            exit;
        }

        try {
            $db = \App\Helpers\DatabaseHelper::getConnection();

            // 2. Ambil info foto sebelum dihapus (untuk menghapus file di server)
            $stmtFoto = $db->prepare("SELECT photo_url FROM candidates WHERE id = :id");
            $stmtFoto->execute(['id' => $id]);
            $cand = $stmtFoto->fetch(\PDO::FETCH_ASSOC);

            // 3. Hapus baris data kandidat
            $stmtDelete = $db->prepare("DELETE FROM candidates WHERE id = :id");
            $stmtDelete->execute(['id' => $id]);

            // 4. Opsional: Hapus file fisik jika bukan link eksternal
            if ($cand && !empty($cand['photo_url']) && strpos($cand['photo_url'], '/assets/') !== false) {
                $path = __DIR__ . '/../../../../public' . $cand['photo_url'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            header('Location: /admin/voting/candidates?status=deleted');
            exit;
        } catch (\PDOException $e) {
            die("Gagal menghapus kandidat: " . $e->getMessage());
        }
    }

    public function storeCandidate()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();

        // 1. Ambil data dari form POST
        $userId      = $_POST['user_id'] ?? null;
        $numberOrder = $_POST['number_order'] ?? 0;
        $visi        = $_POST['visi'] ?? '';
        $misi        = $_POST['misi'] ?? '';

        if (!$userId) {
            header('Location: /admin/voting/candidates?status=error&msg=missing_data');
            exit;
        }

        try {
            // 2. Ambil data profil dari tabel members berdasarkan user_id yang dipilih
            $stmtMember = $db->prepare("SELECT nama_lengkap, nim, divisi, generasi, foto_url FROM members WHERE user_id = :uid");
            $stmtMember->execute(['uid' => $userId]);
            $member = $stmtMember->fetch(\PDO::FETCH_ASSOC);

            if (!$member) {
                die("Error: Data anggota tidak ditemukan.");
            }

            // 3. Logika Foto: Gunakan foto profil member jika tidak ada upload foto khusus
            $photoUrl = $member['foto_url'];

            // Cek jika ada file foto baru yang diunggah
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/profiles/';
                $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $fileName = 'candidate_' . $member['nim'] . '_' . time() . '.' . $fileExtension;
                $destination = __DIR__ . '/../../../../public/' . $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                    $photoUrl = '/' . $uploadDir . $fileName;
                }
            }

            // 4. Insert ke tabel candidates
            $stmt = $db->prepare("
            INSERT INTO candidates (name, nim, generasi, divisi, visi, misi, photo_url, number_order) 
            VALUES (:name, :nim, :gen, :div, :visi, :misi, :photo, :order)
        ");

            $stmt->execute([
                'name'  => $member['nama_lengkap'],
                'nim'   => $member['nim'],
                'gen'   => $member['generasi'],
                'div'   => $member['divisi'],
                'visi'  => $visi,
                'misi'  => $misi,
                'photo' => $photoUrl,
                'order' => $numberOrder
            ]);

            header('Location: /admin/voting/candidates?status=success');
            exit;
        } catch (\Exception $e) {
            die("Gagal menyimpan kandidat: " . $e->getMessage());
        }
    }

    public function results()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);

        // 1. Ambil ID Pemilihan dari URL atau ambil yang terbaru
        $electionId = $_GET['id'] ?? null;
        if (!$electionId) {
            $stmtLatest = $db->query("SELECT id FROM elections ORDER BY created_at DESC LIMIT 1");
            $electionId = $stmtLatest->fetchColumn();
        }

        if (!$electionId) {
            header('Location: /admin/voting/create?msg=no_election_found');
            exit;
        }

        // 2. Ambil Info Detail Pemilihan
        $stmtElection = $db->prepare("SELECT * FROM elections WHERE id = ?");
        $stmtElection->execute([$electionId]);
        $electionInfo = $stmtElection->fetch(\PDO::FETCH_ASSOC);

        // 3. Hitung Total Pemilih Tetap (DPT)
        $stmtTotalMember = $db->query("SELECT COUNT(*) FROM users WHERE role = 'anggota'");
        $totalMembers = (int)$stmtTotalMember->fetchColumn();

        // 4. Hitung Suara Masuk khusus sesi ini
        $stmtTotalVotes = $db->prepare("SELECT COUNT(*) FROM votes WHERE election_id = ?");
        $stmtTotalVotes->execute([$electionId]);
        $totalVotes = (int)$stmtTotalVotes->fetchColumn();

        // 5. Ambil Perolehan Suara per Kandidat khusus sesi ini
        $stmtResults = $db->prepare("
        SELECT 
            c.id, c.name, c.number_order, c.photo_url,
            COUNT(v.id) as total_votes
        FROM candidates c
        LEFT JOIN votes v ON c.id = v.candidate_id AND v.election_id = ?
        WHERE c.election_id = ?
        GROUP BY c.id, c.name, c.number_order, c.photo_url
        ORDER BY total_votes DESC, number_order ASC
    ");
        $stmtResults->execute([$electionId, $electionId]);
        $results = $stmtResults->fetchAll(\PDO::FETCH_ASSOC);

        // 6. Ambil Audit Log khusus sesi ini
        $stmtLogs = $db->prepare("
        SELECT 
            m.nama_lengkap, m.nim, m.generasi,
            c.name as candidate_name, c.number_order,
            v.voted_at
        FROM votes v
        JOIN users u ON v.user_id = u.id
        JOIN members m ON u.id = m.user_id
        JOIN candidates c ON v.candidate_id = c.id
        WHERE v.election_id = ?
        ORDER BY v.voted_at DESC
    ");
        $stmtLogs->execute([$electionId]);
        $voteLogs = $stmtLogs->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/voting/results.php';
    }

    public function create()
    {
        $db = DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);
        require_once __DIR__ . '/../../Views/admin/voting/create.php';
    }

    public function storeElection()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/voting');
            exit;
        }

        $db = \App\Helpers\DatabaseHelper::getConnection();

        // Ambil data dan bersihkan
        $title = $_POST['title'] ?? '';
        $status = $_POST['status'] ?? 'Draft';
        $desc = $_POST['description'] ?? '';
        $start = $_POST['start_date'] ?? null;
        $end = $_POST['end_date'] ?? null;

        // Checkbox logic
        $allowAll = isset($_POST['allow_all']) ? 'true' : 'false';
        $showRealtime = isset($_POST['show_realtime']) ? 'true' : 'false';
        $showAfter = isset($_POST['show_after']) ? 'true' : 'false';

        // Generations array to JSON
        $generations = isset($_POST['generations']) ? json_encode($_POST['generations']) : json_encode([]);

        try {
            $stmt = $db->prepare("
            INSERT INTO elections 
            (title, description, start_date, end_date, status, allow_all_active, eligible_generations, show_realtime_admin, show_result_voter) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

            $stmt->execute([
                $title,
                $desc,
                $start,
                $end,
                $status,
                $allowAll,
                $generations,
                $showRealtime,
                $showAfter
            ]);

            header('Location: /admin/voting?status=success');
            exit;
        } catch (\PDOException $e) {
            die("Gagal menyimpan pemilihan: " . $e->getMessage());
        }
    }
}
