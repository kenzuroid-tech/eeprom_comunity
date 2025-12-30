<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class GalleryController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Bypass ID 2 untuk Navbar
        $userId = 2;

        try {
            $db = DatabaseHelper::getConnection();
            
            // 1. Ambil data User untuk Navbar
            $stmtUser = $db->prepare("SELECT m.nama_lengkap, m.foto_url FROM members m WHERE m.user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // 2. Ambil data Gallery
            $stmtGallery = $db->query("SELECT * FROM gallery ORDER BY event_date DESC");
            $galleryItems = $stmtGallery->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/member-area/gallery/index.php';

        } catch (\PDOException $e) {
            die("Kesalahan Database: " . $e->getMessage());
        }
    }
}