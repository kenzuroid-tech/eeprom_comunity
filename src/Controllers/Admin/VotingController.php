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

    /**
     * Generate kode unik berdasarkan nama dan generasi
     * Format: VOTE-[INISIAL]-[GEN]-[RANDOM]
     * Contoh: VOTE-JD-17-A3X9
     */
    private function generateAccessCode($name, $gen, $prefix = 'VOTE')
    {
        // Ambil inisial dari nama (huruf pertama setiap kata)
        $words = explode(' ', strtoupper($name));
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= $word[0];
            }
        }

        // Random string 4 karakter
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));

        return "{$prefix}-{$initials}-{$gen}-{$random}";
    }

    /**
     * Generate kode untuk semua member/alumni yang eligible
     */
    private function generateCodesForElection($electionId)
    {
        $db = DatabaseHelper::getConnection();

        // Ambil info election
        $stmtElection = $db->prepare("SELECT * FROM elections WHERE id = ?");
        $stmtElection->execute([$electionId]);
        $election = $stmtElection->fetch(\PDO::FETCH_ASSOC);

        if (!$election) return;

        $prefix = $election['code_prefix'] ?? 'VOTE';

        // Query untuk mendapatkan eligible voters
        $query = "SELECT u.id as user_id, m.nama_lengkap, m.nim, m.generasi, u.role 
                  FROM users u 
                  JOIN members m ON u.id = m.user_id 
                  WHERE u.role IN ('anggota', 'alumni')";

        // Filter berdasarkan generasi jika tidak allow_all
        if ($election['allow_all_active'] !== 'true' && !empty($election['eligible_generations'])) {
            $generations = json_decode($election['eligible_generations'], true);
            if (!empty($generations)) {
                $genPlaceholders = implode(',', array_fill(0, count($generations), '?'));
                $query .= " AND m.generasi IN ($genPlaceholders)";
            }
        }

        $stmt = $db->prepare($query);

        if ($election['allow_all_active'] !== 'true' && !empty($election['eligible_generations'])) {
            $generations = json_decode($election['eligible_generations'], true);
            $stmt->execute($generations);
        } else {
            $stmt->execute();
        }

        $eligibleVoters = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Generate kode untuk setiap voter
        $stmtInsert = $db->prepare("
            INSERT INTO voting_access_codes 
            (election_id, code, user_id, user_type, voter_name, voter_identifier) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        foreach ($eligibleVoters as $voter) {
            $code = $this->generateAccessCode(
                $voter['nama_lengkap'],
                $voter['generasi'],
                $prefix
            );

            // Pastikan kode unik
            $attempts = 0;
            while ($this->isCodeExists($code, $electionId) && $attempts < 10) {
                $code = $this->generateAccessCode(
                    $voter['nama_lengkap'],
                    $voter['generasi'],
                    $prefix
                );
                $attempts++;
            }

            $stmtInsert->execute([
                $electionId,
                $code,
                $voter['user_id'],
                $voter['role'],
                $voter['nama_lengkap'],
                $voter['nim']
            ]);
        }
    }

    /**
     * Cek apakah kode sudah ada
     */
    private function isCodeExists($code, $electionId)
    {
        $db = DatabaseHelper::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM voting_access_codes WHERE code = ? AND election_id = ?");
        $stmt->execute([$code, $electionId]);
        return $stmt->fetchColumn() > 0;
    }

    public function index()
    {
        $db = DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);

        $stmtActive = $db->query("SELECT * FROM elections ORDER BY created_at DESC LIMIT 1");
        $activeElection = $stmtActive->fetch(\PDO::FETCH_ASSOC);

        $results = [];
        $totalVotes = 0;
        $totalMembers = 0;

        if ($activeElection) {
            $electionId = $activeElection['id'];
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
        $db = DatabaseHelper::getConnection();

        try {
            $db->exec("TRUNCATE TABLE votes RESTART IDENTITY");

            // Reset status kode akses
            $db->exec("UPDATE voting_access_codes SET is_used = FALSE, used_at = NULL");

            header('Location: /admin/voting?status=reset_success');
            exit;
        } catch (\PDOException $e) {
            die("Gagal mereset data voting: " . $e->getMessage());
        }
    }

    public function candidates()
    {
        $db = DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);

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
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /admin/voting/candidates?status=error');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            $stmtFoto = $db->prepare("SELECT photo_url FROM candidates WHERE id = :id");
            $stmtFoto->execute(['id' => $id]);
            $cand = $stmtFoto->fetch(\PDO::FETCH_ASSOC);

            $stmtDelete = $db->prepare("DELETE FROM candidates WHERE id = :id");
            $stmtDelete->execute(['id' => $id]);

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
        $db = DatabaseHelper::getConnection();

        $userId      = $_POST['user_id'] ?? null;
        $numberOrder = $_POST['number_order'] ?? 0;
        $visi        = $_POST['visi'] ?? '';
        $misi        = $_POST['misi'] ?? '';

        if (!$userId) {
            header('Location: /admin/voting/candidates?status=error&msg=missing_data');
            exit;
        }

        try {
            $stmtMember = $db->prepare("SELECT nama_lengkap, nim, divisi, generasi, foto_url FROM members WHERE user_id = :uid");
            $stmtMember->execute(['uid' => $userId]);
            $member = $stmtMember->fetch(\PDO::FETCH_ASSOC);

            if (!$member) {
                die("Error: Data anggota tidak ditemukan.");
            }

            $photoUrl = $member['foto_url'];

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/profiles/';
                $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $fileName = 'candidate_' . $member['nim'] . '_' . time() . '.' . $fileExtension;
                $destination = __DIR__ . '/../../../../public/' . $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                    $photoUrl = '/' . $uploadDir . $fileName;
                }
            }

            // Ambil election_id terbaru
            $stmtElection = $db->query("SELECT id FROM elections ORDER BY created_at DESC LIMIT 1");
            $electionId = $stmtElection->fetchColumn();

            $stmt = $db->prepare("
                INSERT INTO candidates (election_id, name, nim, generasi, divisi, visi, misi, photo_url, number_order) 
                VALUES (:election_id, :name, :nim, :gen, :div, :visi, :misi, :photo, :order)
            ");

            $stmt->execute([
                'election_id' => $electionId,
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
        $db = DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);

        $electionId = $_GET['id'] ?? null;
        if (!$electionId) {
            $stmtLatest = $db->query("SELECT id FROM elections ORDER BY created_at DESC LIMIT 1");
            $electionId = $stmtLatest->fetchColumn();
        }

        if (!$electionId) {
            header('Location: /admin/voting/create?msg=no_election_found');
            exit;
        }

        $stmtElection = $db->prepare("SELECT * FROM elections WHERE id = ?");
        $stmtElection->execute([$electionId]);
        $electionInfo = $stmtElection->fetch(\PDO::FETCH_ASSOC);

        $stmtTotalMember = $db->query("SELECT COUNT(*) FROM users WHERE role = 'anggota'");
        $totalMembers = (int)$stmtTotalMember->fetchColumn();

        $stmtTotalVotes = $db->prepare("SELECT COUNT(*) FROM votes WHERE election_id = ?");
        $stmtTotalVotes->execute([$electionId]);
        $totalVotes = (int)$stmtTotalVotes->fetchColumn();

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

        $db = DatabaseHelper::getConnection();

        $title = $_POST['title'] ?? '';
        $status = $_POST['status'] ?? 'Draft';
        $desc = $_POST['description'] ?? '';
        $start = $_POST['start_date'] ?? null;
        $end = $_POST['end_date'] ?? null;

        $allowAll = isset($_POST['allow_all']) ? 'true' : 'false';
        $showRealtime = isset($_POST['show_realtime']) ? 'true' : 'false';
        $showAfter = isset($_POST['show_after']) ? 'true' : 'false';

        $generations = isset($_POST['generations']) ? json_encode($_POST['generations']) : json_encode([]);

        try {
            $stmt = $db->prepare("
                INSERT INTO elections 
                (title, description, start_date, end_date, status, allow_all_active, eligible_generations, show_realtime_admin, show_result_voter, requires_access_code, code_prefix) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, TRUE, 'VOTE')
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

            $electionId = $db->lastInsertId();

            // Generate kode akses untuk semua eligible voters
            $this->generateCodesForElection($electionId);

            header('Location: /admin/voting?status=success');
            exit;
        } catch (\PDOException $e) {
            die("Gagal menyimpan pemilihan: " . $e->getMessage());
        }
    }

    /**
     * Halaman Kelola Kode Akses
     */
    public function accessCodes()
    {
        $db = DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);

        // Ambil election terbaru
        $stmtElection = $db->query("SELECT * FROM elections ORDER BY created_at DESC LIMIT 1");
        $election = $stmtElection->fetch(\PDO::FETCH_ASSOC);

        if (!$election) {
            header('Location: /admin/voting/create?msg=no_election');
            exit;
        }

        // Ambil semua kode akses
        $stmtCodes = $db->prepare("
            SELECT * FROM voting_access_codes 
            WHERE election_id = ? 
            ORDER BY user_type, voter_name ASC
        ");
        $stmtCodes->execute([$election['id']]);
        $codes = $stmtCodes->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/voting/access-codes.php';
    }

    /**
     * Generate kode untuk delegasi
     */
    public function generateDelegateCode()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/voting/access-codes');
            exit;
        }

        $db = DatabaseHelper::getConnection();

        $electionId = $_POST['election_id'] ?? null;
        $delegateName = $_POST['delegate_name'] ?? '';
        $delegateIdentifier = $_POST['delegate_identifier'] ?? '';

        $delegateOrigin = $_POST['delegate_origin'] ?? $_POST['origin'] ?? '';

        if (!$electionId || !$delegateName || !$delegateOrigin) {
            // Debugging: jika gagal, cek mana yang kosong
            header('Location: /admin/voting/access-codes?status=error&msg=fields_required');
            exit;
        }

        try {
            // Generate kode untuk delegasi
            $code = $this->generateAccessCode($delegateName, 'DEL', 'VOTE');

            // Pastikan unique
            $attempts = 0;
            while ($this->isCodeExists($code, $electionId) && $attempts < 10) {
                $code = $this->generateAccessCode($delegateName, 'DEL', 'VOTE');
                $attempts++;
            }

            $metadata = json_encode([
                'origin' => $delegateOrigin,
                'registered_at' => date('Y-m-d H:i:s'),
                'created_by' => 'admin'
            ]);

            $stmt = $db->prepare("
            INSERT INTO voting_access_codes 
            (election_id, code, user_id, user_type, voter_name, voter_identifier, voter_metadata) 
            VALUES (?, ?, NULL, 'delegasi', ?, ?, ?)
        ");

            $stmt->execute([
                $electionId,
                $code,
                $delegateName,
                $delegateIdentifier,
                $metadata
            ]);

            header('Location: /admin/voting/access-codes?status=success');
            exit;
        } catch (\PDOException $e) {
            die("Gagal generate kode delegasi: " . $e->getMessage());
        }
    }
    /**
     * Hapus kode akses (hanya untuk delegasi yang belum digunakan)
     */
    public function deleteCode()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /admin/voting/access-codes?status=error');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            // Cek apakah kode adalah delegasi dan belum digunakan
            $stmt = $db->prepare("
                SELECT * FROM voting_access_codes 
                WHERE id = ? AND user_type = 'delegasi' AND is_used = FALSE
            ");
            $stmt->execute([$id]);
            $code = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$code) {
                header('Location: /admin/voting/access-codes?status=cannot_delete');
                exit;
            }

            // Hapus kode
            $stmtDelete = $db->prepare("DELETE FROM voting_access_codes WHERE id = ?");
            $stmtDelete->execute([$id]);

            header('Location: /admin/voting/access-codes?status=deleted');
            exit;
        } catch (\PDOException $e) {
            die("Gagal menghapus kode: " . $e->getMessage());
        }
    }

    /**
     * Export kode ke CSV
     */
    public function exportCodes()
    {
        $electionId = $_GET['id'] ?? null;

        if (!$electionId) {
            header('Location: /admin/voting/access-codes');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            // Ambil data election
            $stmtElection = $db->prepare("SELECT title FROM elections WHERE id = ?");
            $stmtElection->execute([$electionId]);
            $election = $stmtElection->fetch(\PDO::FETCH_ASSOC);

            // Ambil semua kode
            $stmt = $db->prepare("
                SELECT code, voter_name, voter_identifier, user_type, is_used, used_at 
                FROM voting_access_codes 
                WHERE election_id = ? 
                ORDER BY user_type, voter_name
            ");
            $stmt->execute([$electionId]);
            $codes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Set headers untuk download CSV
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="kode-akses-' . date('Y-m-d') . '.csv"');

            $output = fopen('php://output', 'w');

            // Header CSV
            fputcsv($output, ['Kode Akses', 'Nama', 'Identitas', 'Tipe', 'Status', 'Digunakan Pada']);

            // Data
            foreach ($codes as $code) {
                fputcsv($output, [
                    $code['code'],
                    $code['voter_name'],
                    $code['voter_identifier'] ?? '-',
                    ucfirst($code['user_type']),
                    $code['is_used'] ? 'Terpakai' : 'Belum',
                    $code['used_at'] ? date('d/m/Y H:i', strtotime($code['used_at'])) : '-'
                ]);
            }

            fclose($output);
            exit;
        } catch (\PDOException $e) {
            die("Gagal export: " . $e->getMessage());
        }
    }

    public function printVouchers()
    {
        $db = DatabaseHelper::getConnection();
        $electionId = $_GET['id'] ?? null;

        if (!$electionId) {
            header('Location: /admin/voting/access-codes?status=error');
            exit;
        }

        // Ambil semua kode akses untuk pemilihan ini
        $stmt = $db->prepare("SELECT code, voter_name, user_type FROM voting_access_codes WHERE election_id = ? ORDER BY user_type, voter_name ASC");
        $stmt->execute([$electionId]);
        $codes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Kirim data ke view voucher
        require_once __DIR__ . '/../../Views/admin/voting/vouchers-pdf.php';
    }
}
