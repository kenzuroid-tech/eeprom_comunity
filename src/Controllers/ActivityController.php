<?php

namespace App\Controllers;

use App\Helpers\DatabaseHelper;

class ActivityController
{
    public function index()
    {
        $db = DatabaseHelper::getConnection();

        // Ambil input filter dari URL
        $search = $_GET['search'] ?? '';
        $year = $_GET['year'] ?? 'All Years';
        $type = $_GET['type'] ?? 'All Categories';

        // Query Dasar berdasarkan skema tabel activities Anda
        $sql = "SELECT * FROM activities WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND title ILIKE ?";
            $params[] = "%$search%";
        }

        if ($year !== 'All Years') {
            $sql .= " AND EXTRACT(YEAR FROM created_at) = ?";
            $params[] = $year;
        }

        if ($type !== 'All Categories') {
            $sql .= " AND type = ?";
            $params[] = $type;
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $activities = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Ambil daftar tahun unik untuk dropdown filter
        $years = $db->query("SELECT DISTINCT EXTRACT(YEAR FROM created_at) as year FROM activities ORDER BY year DESC")->fetchAll(\PDO::FETCH_COLUMN);

        require_once __DIR__ . '/../Views/activity/index.php';
    }

    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /activity");
            exit;
        }

        $db = DatabaseHelper::getConnection();

        $stmt = $db->prepare("SELECT * FROM activities WHERE id = ?");
        $stmt->execute([$id]);
        $activity = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$activity) {
            die("Kegiatan tidak ditemukan.");
        }

        // Ambil Aktivitas Terkait berdasarkan kolom 'type'
        $stmtRelated = $db->prepare("SELECT * FROM activities WHERE type = ? AND id != ? LIMIT 3");
        $stmtRelated->execute([$activity['type'], $id]);
        $relatedActivities = $stmtRelated->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/activity/detail.php';
    }
}
