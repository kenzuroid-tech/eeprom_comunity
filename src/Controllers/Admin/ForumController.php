<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class ForumController
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
        $db = \App\Helpers\DatabaseHelper::getConnection();
        $adminData = $this->getAdminData($db);

        // 1. Statistik Dasar
        $stats = [
            'total_posts' => $db->query("SELECT COUNT(*) FROM forum_posts")->fetchColumn(),
            'total_replies' => $db->query("SELECT COUNT(*) FROM forum_comments")->fetchColumn(),
            'active_7_days' => $db->query("SELECT COUNT(*) FROM forum_posts WHERE created_at > NOW() - INTERVAL '7 days'")->fetchColumn()
        ];

        // 2. Ambil List Postingan dengan Jumlah Komentar
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';

        $sql = "SELECT f.*, m.nama_lengkap, 
            (SELECT COUNT(*) FROM forum_comments WHERE post_id = f.id) as total_comments
            FROM forum_posts f
            JOIN members m ON f.user_id = m.user_id
            WHERE 1=1";
        $params = [];

        if ($search) {
            $sql .= " AND f.title ILIKE ?";
            $params[] = "%$search%";
        }
        if ($category) {
            $sql .= " AND f.category = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY f.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/forum/index.php';
    }
}
