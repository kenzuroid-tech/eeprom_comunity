<?php

namespace App\Controllers;

use App\Helpers\DatabaseHelper;

class HomeController {
    public function index() {
        $db = DatabaseHelper::getConnection();

        // 1. Ambil Info Organisasi (About, Visi, Misi, Motto)
        $about = $db->query("SELECT * FROM organization_info LIMIT 1")->fetch(\PDO::FETCH_ASSOC);

        // 2. Ambil Divisi (Urutkan berdasarkan sort_order)
        $divisions = $db->query("SELECT * FROM divisions ORDER BY sort_order ASC")->fetchAll(\PDO::FETCH_ASSOC);

        // 3. Ambil Prestasi (Ambil 5 terbaru untuk slider)
        $achievements = $db->query("SELECT * FROM achievements ORDER BY year DESC, id DESC LIMIT 5")->fetchAll(\PDO::FETCH_ASSOC);

        // 4. Hitung Statistik Dinamis
        // Menghitung total anggota dari tabel users yang rolenya 'anggota'
        $totalMembers = $db->query("SELECT COUNT(*) FROM users WHERE role = 'anggota'")->fetchColumn();
        // Menghitung total prestasi
        $totalAchieve = $db->query("SELECT COUNT(*) FROM achievements")->fetchColumn();
        
        $stats = [
            'members' => $totalMembers ?: 0,
            'achievements' => $totalAchieve ?: 0,
            'generasi' => date('Y') - 2011, // Hitung otomatis dari tahun berdiri 2011
            'year' => $about['established_year'] ?? 2011
        ];

        // 5. Cek Rekrutmen Aktif
        $recruitment = $db->query("SELECT * FROM recruitment_periods WHERE status = 'Active' LIMIT 1")->fetch(\PDO::FETCH_ASSOC);

        // Kirim data ke View
        require_once __DIR__ . '/../Views/home/index.php';
    }
}