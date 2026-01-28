<?php

namespace App\Controllers;

use App\Helpers\DatabaseHelper;

class MemberController {
    
    public function index() {
        $db = DatabaseHelper::getConnection();

        // 1. Ambil daftar semua generasi yang ada untuk navigasi tab
        $stmtGen = $db->query("SELECT DISTINCT generasi FROM members ORDER BY generasi DESC");
        $generations = $stmtGen->fetchAll(\PDO::FETCH_COLUMN);

        // 2. Ambil semua data anggota (Gunakan JOIN users untuk mendapatkan email/status aktif)
        $stmt = $db->query("
            SELECT m.*, u.email, u.is_active 
            FROM members m
            JOIN users u ON m.user_id = u.id
            ORDER BY m.nama_lengkap ASC
        ");
        $allMembers = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 3. Kelompokkan anggota berdasarkan generasi agar mudah dilooping di View
        $membersByGen = [];
        foreach ($allMembers as $member) {
            $membersByGen[$member['generasi']][] = $member;
        }

        require_once __DIR__ . '/../Views/member/index.php';
    }

    public function profile() {
        $nim = $_GET['nim'] ?? null;
        if (!$nim) {
            header("Location: /member");
            exit;
        }

        $db = DatabaseHelper::getConnection();

        // Ambil data detail member berdasarkan NIM
        $stmt = $db->prepare("
            SELECT m.*, u.email, u.created_at as join_date 
            FROM members m 
            JOIN users u ON m.user_id = u.id 
            WHERE m.nim = ?
        ");
        $stmt->execute([$nim]);
        $member = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$member) {
            die("Anggota tidak ditemukan.");
        }

        require_once __DIR__ . '/../Views/member/profile.php';
    }

    public function showProfile()
    {
        // 1. Ambil NIM dari parameter URL
        $nim = $_GET['nim'] ?? null;

        if (!$nim) {
            header('Location: /member');
            exit;
        }

        // 2. Gunakan DatabaseHelper agar koneksi konsisten
        $db = \App\Helpers\DatabaseHelper::getConnection();

        // 3. Gunakan Prepared Statement PDO (lebih aman dari SQL Injection)
        $stmt = $db->prepare("
            SELECT m.*, u.email, u.created_at as join_date 
            FROM members m 
            JOIN users u ON m.user_id = u.id 
            WHERE m.nim = ? 
            LIMIT 1
        ");
        $stmt->execute([$nim]);
        $member = $stmt->fetch(\PDO::FETCH_ASSOC);

        // 4. Validasi jika data tidak ditemukan
        if (!$member) {
            die("Data anggota dengan NIM " . htmlspecialchars($nim) . " tidak ditemukan.");
        }

        // 5. Arahkan ke View Profile
        require_once dirname(__DIR__) . '/Views/member/profile.php';
    }
}