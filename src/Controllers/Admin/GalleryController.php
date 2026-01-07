<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class GalleryController
{
    public function index()
    {
        $db = DatabaseHelper::getConnection();
        
        // Memastikan session dimulai untuk mengambil data admin
        if (session_status() === PHP_SESSION_NONE) session_start();
        $adminId = $_SESSION['user_id'] ?? null;

        // Ambil data profil admin untuk Sidebar/Navbar
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmtAdmin->execute(['id' => $adminId]);
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        // Ambil data galeri (asumsi tabel bernama gallery atau activities_images)
        // Jika tabel belum ada, Anda bisa menggunakan data statis sementara atau membuat tabelnya
        try {
            $stmtGallery = $db->query("SELECT * FROM activities ORDER BY id DESC");
            $galleries = $stmtGallery->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $galleries = []; // Fallback jika tabel belum dibuat
        }

        require_once __DIR__ . '/../../Views/admin/gallery/index.php';
    }
}