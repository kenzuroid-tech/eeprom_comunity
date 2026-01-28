<?php

namespace App\Controllers\Delegate;

use App\Helpers\DatabaseHelper;

class DelegateController
{
    /**
     * Halaman Login Delegasi - Tahap 1: Input Data Diri
     */
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Jika sudah login dan verifikasi kode, redirect ke voting
        if (isset($_SESSION['delegate_verified']) && $_SESSION['delegate_verified'] === true) {
            header('Location: /delegate/voting');
            exit;
        }

        require_once __DIR__ . '/../../Views/delegate/login.php';
    }

    /**
     * Proses Input Data Diri - Simpan ke Session, belum generate kode
     */
    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /delegate/login');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $nim = trim($_POST['nim'] ?? '');
        $origin = trim($_POST['origin'] ?? '');

        if (empty($name) || empty($nim) || empty($origin)) {
            header('Location: /delegate/login?status=empty');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            // Ambil election yang sedang aktif
            $stmtElection = $db->query("SELECT * FROM elections WHERE status = 'Active' ORDER BY created_at DESC LIMIT 1");
            $election = $stmtElection->fetch(\PDO::FETCH_ASSOC);

            if (!$election) {
                header('Location: /delegate/login?status=no_election');
                exit;
            }

            $electionId = $election['id'];
            $prefix = $election['code_prefix'] ?? 'VOTE';

            // ========== TAMBAHAN: AUTO-GENERATE KODE ==========

            // Generate kode unik untuk delegasi ini
            $code = $this->generateAccessCode($name, 'DEL', $prefix);

            // Pastikan kode unik
            $attempts = 0;
            while ($this->isCodeExists($code, $electionId) && $attempts < 10) {
                $code = $this->generateAccessCode($name, 'DEL', $prefix);
                $attempts++;
            }

            // Simpan kode ke database
            $metadata = json_encode([
                'origin' => $origin,
                'registered_at' => date('Y-m-d H:i:s'),
                'created_by' => 'auto'
            ]);

            $stmtInsert = $db->prepare("
            INSERT INTO voting_access_codes 
            (election_id, code, user_id, user_type, voter_name, voter_identifier, voter_metadata) 
            VALUES (?, ?, NULL, 'delegasi', ?, ?, ?)
        ");

            $stmtInsert->execute([
                $electionId,
                $code,
                $name,
                $nim,
                $metadata
            ]);

            $codeId = $db->lastInsertId();

            // ========== AKHIR TAMBAHAN ==========

            // Simpan data ke session
            session_start();
            $_SESSION['delegate_temp_name'] = $name;
            $_SESSION['delegate_temp_nim'] = $nim;
            $_SESSION['delegate_temp_origin'] = $origin;
            $_SESSION['delegate_temp_election_id'] = $electionId;
            $_SESSION['delegate_temp_code'] = $code; // Simpan kode yang baru di-generate
            $_SESSION['delegate_temp_code_id'] = $codeId;

            // Redirect ke halaman input kode
            header('Location: /delegate/enter-code');
            exit;
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    // Tambahkan method helper di DelegateController
    private function generateAccessCode($name, $gen, $prefix = 'VOTE')
    {
        $words = explode(' ', strtoupper($name));
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= $word[0];
            }
        }
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
        return "{$prefix}-{$initials}-{$gen}-{$random}";
    }

    private function isCodeExists($code, $electionId)
    {
        $db = DatabaseHelper::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM voting_access_codes WHERE code = ? AND election_id = ?");
        $stmt->execute([$code, $electionId]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Halaman Input Kode Akses - Tahap 2
     */
    public function accessCode()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah sudah input data diri
        if (!isset($_SESSION['delegate_temp_name'])) {
            header('Location: /delegate/login?status=unauthorized');
            exit;
        }

        // Jika sudah verified, redirect ke voting
        if (isset($_SESSION['delegate_verified']) && $_SESSION['delegate_verified'] === true) {
            header('Location: /delegate/voting');
            exit;
        }

        // Siapkan data untuk ditampilkan di view
        $delegateData = [
            'name' => $_SESSION['delegate_temp_name'],
            'nim' => $_SESSION['delegate_temp_nim'],
            'origin' => $_SESSION['delegate_temp_origin']
        ];

        require_once __DIR__ . '/../../Views/delegate/enter-code.php';
    }

    /**
     * Proses Verifikasi Kode Akses
     */
    public function verifyCode()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /delegate/access-code');
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah sudah input data diri
        if (!isset($_SESSION['delegate_temp_name'])) {
            header('Location: /delegate/login?status=unauthorized');
            exit;
        }

        $accessCode = trim($_POST['access_code'] ?? '');

        if (empty($accessCode)) {
            header('Location: /delegate/access-code?status=empty');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            $electionId = $_SESSION['delegate_temp_election_id'];
            $name = $_SESSION['delegate_temp_name'];
            $nim = $_SESSION['delegate_temp_nim'];
            $origin = $_SESSION['delegate_temp_origin'];

            // Cari kode akses di database
            $stmtCode = $db->prepare("
                SELECT * FROM voting_access_codes 
                WHERE code = ? 
                AND election_id = ? 
                AND user_type = 'delegasi'
                AND is_used = FALSE
            ");
            $stmtCode->execute([$accessCode, $electionId]);
            $codeData = $stmtCode->fetch(\PDO::FETCH_ASSOC);

            // Validasi kode
            if (!$codeData) {
                header('Location: /delegate/access-code?status=invalid');
                exit;
            }

            // Update data delegasi di database dengan info lengkap
            $stmtUpdate = $db->prepare("
                UPDATE voting_access_codes 
                SET voter_name = ?, 
                    voter_identifier = ?,
                    voter_metadata = ?
                WHERE id = ?
            ");

            $metadata = json_encode([
                'origin' => $origin,
                'registered_at' => date('Y-m-d H:i:s')
            ]);

            $stmtUpdate->execute([$name, $nim, $metadata, $codeData['id']]);

            // Set session untuk voting (pindahkan dari temp ke permanent)
            $_SESSION['delegate_id'] = $codeData['id'];
            $_SESSION['delegate_name'] = $name;
            $_SESSION['delegate_nim'] = $nim;
            $_SESSION['delegate_origin'] = $origin;
            $_SESSION['delegate_election_id'] = $electionId;
            $_SESSION['delegate_code'] = $accessCode;
            $_SESSION['delegate_verified'] = true;

            // Hapus session temporary
            unset($_SESSION['delegate_temp_name']);
            unset($_SESSION['delegate_temp_nim']);
            unset($_SESSION['delegate_temp_origin']);
            unset($_SESSION['delegate_temp_election_id']);

            header('Location: /delegate/voting');
            exit;
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
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
        unset($_SESSION['delegate_temp_name']);
        unset($_SESSION['delegate_temp_nim']);
        unset($_SESSION['delegate_temp_origin']);
        unset($_SESSION['delegate_temp_election_id']);

        header('Location: /delegate/login');
        exit;
    }

    /**
     * Halaman Voting untuk Delegasi
     */
    public function voting()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek session delegasi sudah terverifikasi
        if (!isset($_SESSION['delegate_verified']) || $_SESSION['delegate_verified'] !== true) {
            header('Location: /delegate/login?status=unauthorized');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            $delegateId = $_SESSION['delegate_id'];
            $delegateName = $_SESSION['delegate_name'];
            $delegateOrigin = $_SESSION['delegate_origin'];
            $electionId = $_SESSION['delegate_election_id'];
            $accessCode = $_SESSION['delegate_code'];

            // Ambil info election
            $stmtElection = $db->prepare("SELECT * FROM elections WHERE id = ?");
            $stmtElection->execute([$electionId]);
            $election = $stmtElection->fetch(\PDO::FETCH_ASSOC);

            if (!$election || $election['status'] !== 'Active') {
                header('Location: /delegate/login?status=election_closed');
                exit;
            }

            // Cek apakah kode sudah digunakan
            $stmtCode = $db->prepare("SELECT is_used FROM voting_access_codes WHERE id = ?");
            $stmtCode->execute([$delegateId]);
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

            require_once __DIR__ . '/../../Views/delegate/voting.php';
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    /**
     * Submit Vote Delegasi
     */
    public function submitVote()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /delegate/voting');
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['delegate_verified']) || $_SESSION['delegate_verified'] !== true) {
            header('Location: /delegate/login?status=unauthorized');
            exit;
        }

        $candidateId = $_POST['candidate_id'] ?? null;

        if (!$candidateId) {
            header('Location: /delegate/voting?status=no_candidate');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            $delegateCodeId = $_SESSION['delegate_id'];
            $electionId = $_SESSION['delegate_election_id'];
            $delegateName = $_SESSION['delegate_name'];
            $delegateNim = $_SESSION['delegate_nim'];
            $delegateOrigin = $_SESSION['delegate_origin'];

            // Cek apakah sudah voting
            $stmtCheck = $db->prepare("SELECT is_used FROM voting_access_codes WHERE id = ?");
            $stmtCheck->execute([$delegateCodeId]);
            $codeData = $stmtCheck->fetch(\PDO::FETCH_ASSOC);

            if ($codeData['is_used']) {
                header('Location: /delegate/voting?status=already_voted');
                exit;
            }

            // Begin transaction
            $db->beginTransaction();

            // Simpan vote dengan metadata delegasi
            $stmtVote = $db->prepare("
                INSERT INTO votes (user_id, candidate_id, election_id, voted_at, voter_type, voter_metadata) 
                VALUES (NULL, ?, ?, CURRENT_TIMESTAMP, 'delegasi', ?)
            ");

            $metadata = json_encode([
                'name' => $delegateName,
                'nim' => $delegateNim,
                'origin' => $delegateOrigin
            ]);

            $stmtVote->execute([$candidateId, $electionId, $metadata]);

            // Update kode akses menjadi terpakai
            $stmtUpdate = $db->prepare("
                UPDATE voting_access_codes 
                SET is_used = TRUE, used_at = CURRENT_TIMESTAMP 
                WHERE id = ?
            ");
            $stmtUpdate->execute([$delegateCodeId]);

            $db->commit();

            header('Location: /delegate/voting?status=success');
            exit;
        } catch (\PDOException $e) {
            if (isset($db)) {
                $db->rollBack();
            }
            die("Gagal menyimpan vote: " . $e->getMessage());
        }
    }

    /**
     * Logout Delegasi
     */
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Hapus semua session delegasi (permanent dan temporary)
        unset($_SESSION['delegate_id']);
        unset($_SESSION['delegate_name']);
        unset($_SESSION['delegate_nim']);
        unset($_SESSION['delegate_origin']);
        unset($_SESSION['delegate_election_id']);
        unset($_SESSION['delegate_code']);
        unset($_SESSION['delegate_verified']);

        unset($_SESSION['delegate_temp_name']);
        unset($_SESSION['delegate_temp_nim']);
        unset($_SESSION['delegate_temp_origin']);
        unset($_SESSION['delegate_temp_election_id']);

        session_destroy();

        header('Location: /delegate/login?status=logged_out');
        exit;
    }
}
