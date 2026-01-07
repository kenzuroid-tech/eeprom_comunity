<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class ActivitiesController
{
    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $this->startSession();

        // Pastikan admin sudah login (id 3 sesuai contoh sebelumnya)
        $adminId = 3;

        try {
            $db = DatabaseHelper::getConnection();

            // 1. Ambil data Admin untuk Navbar
            $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtAdmin->execute(['id' => $adminId]);
            $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);
            $adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : '/assets/images/default-avatar.png';

            // 2. Ambil data Aktivitas/Kegiatan dari database
            // Gantilah 'activities' dengan nama tabel yang sesuai di databasemu
            $stmt = $db->query("SELECT * FROM activities ORDER BY created_at DESC");
            $activities = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // 3. Panggil View
            require_once __DIR__ . '/../../Views/admin/activities/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }

    public function create()
    {
        $this->startSession();
        $adminId = 3; // Sesuaikan dengan login session jika sudah ada

        $db = \App\Helpers\DatabaseHelper::getConnection();

        // Ambil data admin untuk navbar
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmtAdmin->execute(['id' => $adminId]);
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);
        $adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : '/assets/images/default-avatar.png';

        // Panggil file View (pastikan file ini sudah Anda buat)
        require_once __DIR__ . '/../../Views/admin/activities/create.php';
    }

    public function store()
    {
        // Logika untuk menyimpan kegiatan baru
    }
}
