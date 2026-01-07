<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class DocumentController
{
    public function index()
    {
        // 1. Inisialisasi Session dan ambil User ID otomatis
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek apakah user sudah login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        try {
            $db = \App\Helpers\DatabaseHelper::getConnection();

            // 2. Ambil data user untuk Navbar (menggunakan ID otomatis)
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // Definisikan fotoPath agar sinkron dengan View navbar yang kita rapikan tadi
            $fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';

            // 3. Ambil data dokumen
            $stmtDocs = $db->query("SELECT * FROM documents ORDER BY uploaded_at DESC");
            $documents = $stmtDocs->fetchAll(\PDO::FETCH_ASSOC);

            // 4. Load View
            require_once __DIR__ . '/../../Views/member-area/documents/index.php';
            
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }
}