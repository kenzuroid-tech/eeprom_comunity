<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class VotingController
{
    private function getLoggedInUserId()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        return $_SESSION['user_id'];
    }

    public function index()
    {
        $userId = $this->getLoggedInUserId();

        try {
            $db = DatabaseHelper::getConnection();

            // Ambil data user
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            $fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';

            // Ambil election terbaru yang aktif
            $stmtElection = $db->query("
                SELECT * FROM elections 
                WHERE status = 'Active' 
                ORDER BY created_at DESC LIMIT 1
            ");
            $election = $stmtElection->fetch(\PDO::FETCH_ASSOC);

            if (!$election) {
                $noElection = true;
                require_once __DIR__ . '/../../Views/member-area/voting/index.php';
                return;
            }

            // Cek apakah user punya access code
            $stmtCode = $db->prepare("
                SELECT * FROM voting_access_codes 
                WHERE election_id = ? AND user_id = ? AND is_used = FALSE
            ");
            $stmtCode->execute([$election['id'], $userId]);
            $accessCode = $stmtCode->fetch(\PDO::FETCH_ASSOC);

            // Cek apakah sudah vote
            $stmtCheck = $db->prepare("
                SELECT v.*, c.name as candidate_name, c.number_order 
                FROM votes v 
                JOIN candidates c ON v.candidate_id = c.id 
                WHERE v.user_id = :id AND v.election_id = :eid
            ");
            $stmtCheck->execute(['id' => $userId, 'eid' => $election['id']]);
            $userVote = $stmtCheck->fetch(\PDO::FETCH_ASSOC);

            // Ambil kandidat
            $stmtCand = $db->prepare("
                SELECT * FROM candidates 
                WHERE election_id = ? 
                ORDER BY number_order ASC
            ");
            $stmtCand->execute([$election['id']]);
            $candidates = $stmtCand->fetchAll(\PDO::FETCH_ASSOC);

            // Statistik
            $stmtStats = $db->prepare("
                SELECT c.id, c.name, COUNT(v.id) as total_votes 
                FROM candidates c 
                LEFT JOIN votes v ON c.id = v.candidate_id AND v.election_id = ?
                WHERE c.election_id = ?
                GROUP BY c.id, c.name
            ");
            $stmtStats->execute([$election['id'], $election['id']]);
            $stats = $stmtStats->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/member-area/voting/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }

    /**
     * Halaman input kode akses
     */
    public function enterCode()
    {
        $userId = $this->getLoggedInUserId();
        $db = DatabaseHelper::getConnection();

        // Ambil data user
        $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmtUser->execute(['id' => $userId]);
        $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

        $fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';

        require_once __DIR__ . '/../../Views/member-area/voting/enter-code.php';
    }

    /**
     * Verifikasi kode akses
     */
    public function verifyCode()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /member/voting');
            exit;
        }

        $userId = $this->getLoggedInUserId();
        $code = strtoupper(trim($_POST['access_code'] ?? ''));

        if (empty($code)) {
            header('Location: /member/voting/enter-code?status=empty');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            // Cari kode
            $stmtCode = $db->prepare("
                SELECT * FROM voting_access_codes 
                WHERE code = ? AND is_used = FALSE
            ");
            $stmtCode->execute([$code]);
            $accessCode = $stmtCode->fetch(\PDO::FETCH_ASSOC);

            if (!$accessCode) {
                header('Location: /member/voting/enter-code?status=invalid');
                exit;
            }

            // Validasi: kode harus untuk user ini (jika bukan delegasi)
            if ($accessCode['user_type'] !== 'delegasi' && $accessCode['user_id'] != $userId) {
                header('Location: /member/voting/enter-code?status=not_yours');
                exit;
            }

            // Simpan kode di session untuk dipakai saat submit
            session_start();
            $_SESSION['voting_code_id'] = $accessCode['id'];
            $_SESSION['voting_election_id'] = $accessCode['election_id'];

            header('Location: /member/voting?code_verified=1');
            exit;
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function submit()
    {
        session_start();
        $userId = $this->getLoggedInUserId();
        $candidateId = $_POST['candidate_id'] ?? null;

        if (!$candidateId) {
            die("Silakan pilih kandidat terlebih dahulu.");
        }

        // Validasi kode akses dari session
        if (!isset($_SESSION['voting_code_id']) || !isset($_SESSION['voting_election_id'])) {
            header('Location: /member/voting/enter-code?status=no_code');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();
            $codeId = $_SESSION['voting_code_id'];
            $electionId = $_SESSION['voting_election_id'];

            // Cek apakah sudah vote
            $stmtCheck = $db->prepare("
                SELECT id FROM votes 
                WHERE user_id = :uid AND election_id = :eid
            ");
            $stmtCheck->execute(['uid' => $userId, 'eid' => $electionId]);

            if ($stmtCheck->fetch()) {
                header('Location: /member/voting?status=already_voted');
                exit;
            }

            // Begin transaction
            $db->beginTransaction();

            // Simpan vote
            $stmtInsert = $db->prepare("
                INSERT INTO votes (user_id, candidate_id, election_id, voted_at) 
                VALUES (:uid, :cid, :eid, CURRENT_TIMESTAMP)
            ");
            $stmtInsert->execute([
                'uid' => $userId,
                'cid' => $candidateId,
                'eid' => $electionId
            ]);

            // Update kode akses menjadi used
            $stmtUpdate = $db->prepare("
                UPDATE voting_access_codes 
                SET is_used = TRUE, used_at = CURRENT_TIMESTAMP 
                WHERE id = ?
            ");
            $stmtUpdate->execute([$codeId]);

            $db->commit();

            // Hapus session kode
            unset($_SESSION['voting_code_id']);
            unset($_SESSION['voting_election_id']);

            header('Location: /member/voting?status=success');
            exit;
        } catch (\PDOException $e) {
            $db->rollBack();
            die("Gagal menyimpan suara: " . $e->getMessage());
        }
    }
}
