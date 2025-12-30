<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class DocumentController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userId = 2; // Bypass ID 2 sementara

        try {
            $db = \App\Helpers\DatabaseHelper::getConnection();

            // Ambil data user untuk Navbar
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // Ambil data dokumen
            $stmtDocs = $db->query("SELECT * FROM documents ORDER BY uploaded_at DESC");
            $documents = $stmtDocs->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/member-area/documents/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }
}
