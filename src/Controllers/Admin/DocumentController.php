<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class DocumentController
{
    public function index()
    {
        $db = DatabaseHelper::getConnection();
        
        // Memastikan session dimulai untuk mengambil data admin
        if (session_status() === PHP_SESSION_NONE) session_start();
        $adminId = $_SESSION['user_id'] ?? null;

        // Ambil data profil admin untuk Sidebar
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmtAdmin->execute(['id' => $adminId]);
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        // Ambil daftar dokumen (Pastikan kolom pengurutan sesuai dengan database)
        // Gunakan 'id' jika 'created_at' belum ditambahkan ke tabel
        $stmtDocs = $db->query("SELECT * FROM documents ORDER BY id DESC");
        $documents = $stmtDocs->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/documents/index.php';
    }
}