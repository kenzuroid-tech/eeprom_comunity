<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class GalleryController
{
    public function index()
    {
        // 1. Inisialisasi Session dan ambil User ID secara dinamis
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah user sudah login, jika tidak, arahkan ke halaman login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        try {
            $db = DatabaseHelper::getConnection();
            
            // 2. Ambil data User untuk Navbar
            $stmtUser = $db->prepare("SELECT m.nama_lengkap, m.foto_url FROM members m WHERE m.user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // Definisikan fotoPath agar sesuai dengan View navbar yang sudah kita rapikan
            $fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';

            // 3. Ambil data Gallery
            $stmtGallery = $db->query("SELECT * FROM gallery ORDER BY event_date DESC");
            $galleryItems = $stmtGallery->fetchAll(\PDO::FETCH_ASSOC);

            // 4. Load View
            require_once __DIR__ . '/../../Views/member-area/gallery/index.php';

        } catch (\PDOException $e) {
            die("Kesalahan Database: " . $e->getMessage());
        }
    }
}