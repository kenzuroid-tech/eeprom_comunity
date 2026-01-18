<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class AchievementsController
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

        $stmt = $db->query("SELECT * FROM achievements ORDER BY year DESC, id DESC");
        $achievements = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/achievements/index.php';
    }

    public function store()
    {
        $db = DatabaseHelper::getConnection();
        $stmt = $db->prepare("INSERT INTO achievements (title, rank, event_name, year, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['rank'], $_POST['event_name'], $_POST['year'], $_POST['description']]);
        header('Location: /admin/achievements?status=success');
    }

    public function delete()
    {
        $db = DatabaseHelper::getConnection();
        $stmt = $db->prepare("DELETE FROM achievements WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        header('Location: /admin/achievements?status=deleted');
    }
}