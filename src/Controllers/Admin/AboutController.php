<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class AboutController
{
    private function getAdminData($db)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $adminId = $_SESSION['user_id'] ?? null;
        $stmt = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmt->execute(['id' => $adminId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function index()
    {
        $db = DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);

        // Ambil data tentang organisasi (asumsi tabel bernama organization_info)
        // Jika belum ada tabel, Anda bisa mengirimkan data dummy atau string kosong
        $stmt = $db->query("SELECT * FROM organization_info LIMIT 1");
        $aboutData = $stmt->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/about/index.php';
    }

    public function update()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();
        $aboutText = $_POST['about_text'] ?? '';
        $historyText = $_POST['history_text'] ?? '';
        $year = $_POST['established_year'] ?? 2015;

        $stmt = $db->prepare("UPDATE organization_info SET about_text = ?, history_text = ?, established_year = ? WHERE id = (SELECT id FROM organization_info LIMIT 1)");
        $stmt->execute([$aboutText, $historyText, $year]);

        header('Location: /admin/about?status=success');
    }
}
