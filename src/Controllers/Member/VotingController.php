<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class VotingController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userId = 2; // Bypass sementara ID 2

        try {
            $db = \App\Helpers\DatabaseHelper::getConnection();

            // 1. Ambil data User untuk Navbar
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // 2. C check apakah user sudah memilih
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

            // 4. Hitung Statistik (untuk mode Selesai/Closed)
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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Bypass ID 2 (Nikmatus Sholihah) sesuai permintaan Anda
        $userId = 2;

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
                die("Anda sudah menggunakan hak suara Anda. Pilihan tidak dapat diubah.");
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
