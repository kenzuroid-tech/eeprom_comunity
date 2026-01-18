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

        // Cek apakah ada session user_id, jika tidak ada arahkan ke login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        return $_SESSION['user_id'];
    }

    public function index()
    {
        // Ambil ID otomatis dari Session
        $userId = $this->getLoggedInUserId();

        try {
            $db = \App\Helpers\DatabaseHelper::getConnection();

            // 1. Ambil data User untuk Navbar
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);
            
            // Variabel fotoPath untuk konsistensi view yang kita buat sebelumnya
            $fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';

            // 2. Cek apakah user sudah memilih
            $stmtCheck = $db->prepare("
                SELECT v.*, c.name as candidate_name, c.number_order 
                FROM votes v 
                JOIN candidates c ON v.candidate_id = c.id 
                WHERE v.user_id = :id
            ");
            $stmtCheck->execute(['id' => $userId]);
            $userVote = $stmtCheck->fetch(\PDO::FETCH_ASSOC);

            // 3. Ambil daftar kandidat
            $stmtCand = $db->query("SELECT * FROM candidates ORDER BY number_order ASC");
            $candidates = $stmtCand->fetchAll(\PDO::FETCH_ASSOC);

            // 4. Hitung Statistik
            $stmtStats = $db->query("
                SELECT c.id, c.name, COUNT(v.id) as total_votes 
                FROM candidates c 
                LEFT JOIN votes v ON c.id = v.candidate_id 
                GROUP BY c.id, c.name
            ");
            $stats = $stmtStats->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/member-area/voting/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }

    public function submit()
    {
        // Ambil ID otomatis dari Session
        $userId = $this->getLoggedInUserId();

        // Ambil ID Kandidat dari form
        $candidateId = $_POST['candidate_id'] ?? null;

        if (!$candidateId) {
            die("Silakan pilih kandidat terlebih dahulu.");
        }

        try {
            $db = \App\Helpers\DatabaseHelper::getConnection();

            // 1. Validasi: Cek apakah user sudah pernah memilih sebelumnya
            $stmtCheck = $db->prepare("SELECT id FROM votes WHERE user_id = :uid");
            $stmtCheck->execute(['uid' => $userId]);

            if ($stmtCheck->fetch()) {
                // Sebaiknya redirect dengan pesan error daripada die
                header('Location: /member/voting?status=already_voted');
                exit;
            }

            // 2. Simpan suara ke tabel votes
            $stmtInsert = $db->prepare("
                INSERT INTO votes (user_id, candidate_id, voted_at) 
                VALUES (:uid, :cid, CURRENT_TIMESTAMP)
            ");

            $stmtInsert->execute([
                'uid' => $userId,
                'cid' => $candidateId
            ]);

            // 3. Redirect kembali ke halaman voting dengan status sukses
            header('Location: /member/voting?status=success');
            exit;
        } catch (\PDOException $e) {
            die("Gagal menyimpan suara: " . $e->getMessage());
        }
    }
}