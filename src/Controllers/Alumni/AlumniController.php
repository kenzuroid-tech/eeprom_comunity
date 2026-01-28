<?php

namespace App\Controllers\Alumni;

use App\Helpers\DatabaseHelper;

class AlumniController
{
    /**
     * Halaman Login Alumni - Tahap 1: Input Data Diri
     */
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Jika sudah verified, redirect ke voting
        if (isset($_SESSION['alumni_verified']) && $_SESSION['alumni_verified'] === true) {
            header('Location: /alumni/vote');
            exit;
        }

        require_once __DIR__ . '/../../Views/alumni/login.php';
    }

    /**
     * Proses Input Data Diri - Generate Kode dan Redirect ke Input Kode
     */
    public function processLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /alumni/login');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $graduationYear = trim($_POST['graduation_year'] ?? '');

        if (empty($name) || empty($graduationYear)) {
            header('Location: /alumni/login?status=empty');
            exit;
        }

        $db = DatabaseHelper::getConnection();

        // Cek election aktif
        $stmtElection = $db->query("SELECT * FROM elections WHERE status = 'Active' ORDER BY created_at DESC LIMIT 1");
        $election = $stmtElection->fetch(\PDO::FETCH_ASSOC);

        if (!$election) {
            header('Location: /alumni/login?status=no_election');
            exit;
        }

        // Cari kode akses yang sudah ada
        $stmtCode = $db->prepare("
            SELECT * FROM voting_access_codes 
            WHERE election_id = :election_id 
            AND user_type = 'alumni'
            AND LOWER(TRIM(voter_name)) = LOWER(:name)
            AND voter_metadata LIKE :graduation_year
            LIMIT 1
        ");

        $stmtCode->execute([
            'election_id' => $election['id'],
            'name' => $name,
            'graduation_year' => '%"graduation_year":"' . $graduationYear . '"%'
        ]);

        $accessCode = $stmtCode->fetch(\PDO::FETCH_ASSOC);

        if (!$accessCode) {
            // Buat kode akses baru
            $code = $this->generateUniqueCode($db, $election['id'], $name, $graduationYear);
            $metadata = json_encode([
                'graduation_year' => $graduationYear,
                'registered_at' => date('Y-m-d H:i:s'),
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);

            $stmtInsert = $db->prepare("
                INSERT INTO voting_access_codes 
                (election_id, code, user_id, user_type, voter_name, voter_identifier, voter_metadata, is_used) 
                VALUES (:election_id, :code, NULL, 'alumni', :name, :nim, :metadata, false)
            ");

            $stmtInsert->execute([
                'election_id' => $election['id'],
                'code' => $code,
                'name' => $name,
                'nim' => 'ALM-' . time(),
                'metadata' => $metadata
            ]);

            $accessCodeId = $db->lastInsertId('voting_access_codes_id_seq');
        } else {
            // Jika sudah voting
            if ($accessCode['is_used']) {
                header('Location: /alumni/login?status=already_voted');
                exit;
            }
            $accessCodeId = $accessCode['id'];
            $code = $accessCode['code'];
        }

        // Simpan data TEMPORARY ke session untuk verifikasi di tahap berikutnya
        $_SESSION['alumni_temp_name'] = $name;
        $_SESSION['alumni_temp_graduation_year'] = $graduationYear;
        $_SESSION['alumni_temp_code'] = $code;
        $_SESSION['alumni_temp_code_id'] = $accessCodeId;
        $_SESSION['alumni_temp_election_id'] = $election['id'];

        session_write_close();

        // Redirect ke halaman input kode
        header('Location: /alumni/enter-code');
        exit;
    }

    /**
     * Generate Unique Code
     */
    private function generateUniqueCode($db, $electionId, $name, $gen)
    {
        $words = explode(' ', strtoupper($name));
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= $word[0];
            }
        }

        do {
            $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
            $code = "VOTE-{$initials}-{$gen}-{$random}";

            $stmt = $db->prepare("SELECT COUNT(*) FROM voting_access_codes WHERE code = ? AND election_id = ?");
            $stmt->execute([$code, $electionId]);
            $exists = $stmt->fetchColumn() > 0;
        } while ($exists);

        return $code;
    }

    /**
     * Halaman Input Kode Akses - Tahap 2
     */
    public function accessCode()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah alumni sudah input data diri di tahap sebelumnya
        if (!isset($_SESSION['alumni_temp_name'])) {
            header('Location: /alumni/login?status=unauthorized');
            exit;
        }

        // Jika sudah verified, langsung ke voting
        if (isset($_SESSION['alumni_verified']) && $_SESSION['alumni_verified'] === true) {
            header('Location: /alumni/vote');
            exit;
        }

        // Data untuk ditampilkan di View
        $alumniData = [
            'name' => $_SESSION['alumni_temp_name'],
            'graduation_year' => $_SESSION['alumni_temp_graduation_year'],
            'code_hint' => $_SESSION['alumni_temp_code']
        ];

        require_once __DIR__ . '/../../Views/alumni/enter-code.php';
    }

    /**
     * Proses Verifikasi Kode Akses
     */
    public function verifyCode()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /alumni/access-code');
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validasi Session Temp
        if (!isset($_SESSION['alumni_temp_name'])) {
            header('Location: /alumni/login?status=unauthorized');
            exit;
        }

        $accessCode = strtoupper(trim($_POST['access_code'] ?? ''));

        if (empty($accessCode)) {
            header('Location: /alumni/access-code?status=empty');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            // Ambil data dari session temp
            $electionId = $_SESSION['alumni_temp_election_id'];
            $expectedCode = $_SESSION['alumni_temp_code'];
            $codeId = $_SESSION['alumni_temp_code_id'];
            $name = $_SESSION['alumni_temp_name'];
            $graduationYear = $_SESSION['alumni_temp_graduation_year'];

            // Verifikasi kode cocok dengan yang di-generate
            if ($accessCode !== $expectedCode) {
                header('Location: /alumni/access-code?status=invalid');
                exit;
            }

            // Cek apakah kode masih valid di database
            $stmtCode = $db->prepare("
                SELECT id, is_used FROM voting_access_codes 
                WHERE id = ? 
                AND election_id = ? 
                AND code = ?
                LIMIT 1
            ");
            $stmtCode->execute([$codeId, $electionId, $accessCode]);
            $codeData = $stmtCode->fetch(\PDO::FETCH_ASSOC);

            if (!$codeData) {
                header('Location: /alumni/access-code?status=invalid');
                exit;
            }

            if ($codeData['is_used']) {
                header('Location: /alumni/access-code?status=already_voted');
                exit;
            }

            // MIGRASI SESSION dari Temp ke Verified
            $_SESSION['alumni_verified'] = true;
            $_SESSION['access_code_id'] = $codeId;
            $_SESSION['voter_name'] = $name;
            $_SESSION['graduation_year'] = $graduationYear;
            $_SESSION['election_id'] = $electionId;
            $_SESSION['voter_type'] = 'alumni';
            $_SESSION['generated_code'] = $accessCode;

            // Bersihkan Session Temporary
            $this->clearTempSession();

            header('Location: /alumni/vote');
            exit;
        } catch (\PDOException $e) {
            error_log("VerifyCode Error: " . $e->getMessage());
            die("Terjadi kesalahan pada server.");
        }
    }

    /**
     * Bersihkan Session Temporary
     */
    private function clearTempSession()
    {
        $tempKeys = [
            'alumni_temp_name',
            'alumni_temp_graduation_year',
            'alumni_temp_election_id',
            'alumni_temp_code',
            'alumni_temp_code_id'
        ];
        foreach ($tempKeys as $key) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Kembali ke halaman login (reset session temporary)
     */
    public function backToLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Hapus session temporary
        $this->clearTempSession();

        header('Location: /alumni/login');
        exit;
    }

    /**
     * Halaman Voting untuk Alumni
     */
    public function vote()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek session alumni sudah terverifikasi
        if (!isset($_SESSION['alumni_verified']) || $_SESSION['alumni_verified'] !== true) {
            header('Location: /alumni/login?status=unauthorized');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            $accessCodeId = $_SESSION['access_code_id'];
            $alumniName = $_SESSION['voter_name'];
            $electionId = $_SESSION['election_id'];
            $generatedCode = $_SESSION['generated_code'] ?? '';

            // Ambil info election
            $stmtElection = $db->prepare("SELECT * FROM elections WHERE id = ?");
            $stmtElection->execute([$electionId]);
            $election = $stmtElection->fetch(\PDO::FETCH_ASSOC);

            if (!$election || $election['status'] !== 'Active') {
                header('Location: /alumni/login?status=election_closed');
                exit;
            }

            // Cek apakah kode sudah digunakan
            $stmtCode = $db->prepare("SELECT is_used FROM voting_access_codes WHERE id = ?");
            $stmtCode->execute([$accessCodeId]);
            $codeStatus = $stmtCode->fetch(\PDO::FETCH_ASSOC);

            $hasVoted = $codeStatus['is_used'] ?? true;

            // Ambil kandidat
            $stmtCand = $db->prepare("
                SELECT * FROM candidates 
                WHERE election_id = ? 
                ORDER BY number_order ASC
            ");
            $stmtCand->execute([$electionId]);
            $candidates = $stmtCand->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/alumni/voting.php';
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    /**
     * Submit Vote Alumni
     */
    public function submitVote()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /alumni/vote');
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['alumni_verified']) || $_SESSION['alumni_verified'] !== true) {
            header('Location: /alumni/login?status=unauthorized');
            exit;
        }

        $candidateId = $_POST['candidate_id'] ?? null;

        if (!$candidateId) {
            header('Location: /alumni/vote?status=no_candidate');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            $accessCodeId = $_SESSION['access_code_id'];
            $electionId = $_SESSION['election_id'];
            $alumniName = $_SESSION['voter_name'];
            $graduationYear = $_SESSION['graduation_year'];

            // Cek apakah sudah voting
            $stmtCheck = $db->prepare("SELECT is_used FROM voting_access_codes WHERE id = ?");
            $stmtCheck->execute([$accessCodeId]);
            $codeData = $stmtCheck->fetch(\PDO::FETCH_ASSOC);

            if ($codeData['is_used']) {
                header('Location: /alumni/vote?status=already_voted');
                exit;
            }

            // Begin transaction
            $db->beginTransaction();

            // Simpan vote dengan metadata alumni
            $stmtVote = $db->prepare("
                INSERT INTO votes (user_id, candidate_id, election_id, voted_at, voter_type, voter_metadata) 
                VALUES (NULL, ?, ?, CURRENT_TIMESTAMP, 'alumni', ?)
            ");

            $metadata = json_encode([
                'name' => $alumniName,
                'graduation_year' => $graduationYear
            ]);

            $stmtVote->execute([$candidateId, $electionId, $metadata]);

            // Update kode akses menjadi terpakai
            $stmtUpdate = $db->prepare("
                UPDATE voting_access_codes 
                SET is_used = TRUE, used_at = CURRENT_TIMESTAMP 
                WHERE id = ?
            ");
            $stmtUpdate->execute([$accessCodeId]);

            $db->commit();

            header('Location: /alumni/vote?status=success');
            exit;
        } catch (\PDOException $e) {
            if (isset($db)) {
                $db->rollBack();
            }
            die("Gagal menyimpan vote: " . $e->getMessage());
        }
    }

    /**
     * Logout Alumni
     */
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Hapus semua session
        session_unset();
        session_destroy();

        header('Location: /alumni/login?status=logged_out');
        exit;
    }
}
