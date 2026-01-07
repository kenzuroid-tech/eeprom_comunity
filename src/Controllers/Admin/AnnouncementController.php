<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class AnnouncementController
{
    public function index()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();

        $category = $_GET['category'] ?? '';
        $statusFilter = $_GET['status_filter'] ?? '';

        $sql = "SELECT * FROM announcements WHERE 1=1";
        $params = [];

        if (!empty($category)) {
            $sql .= " AND LOWER(category) = LOWER(?)";
            $params[] = $category;
        }

        if (!empty($statusFilter)) {
            $sql .= " AND LOWER(status) = LOWER(?)";
            $params[] = $statusFilter;
        }

        $sql .= " ORDER BY created_at DESC";

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $announcements = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
            $stmtAdmin->execute();
            $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/admin/announcements/index.php';
        } catch (\Exception $e) {
            die("Terjadi kesalahan pada database: " . $e->getMessage());
        }
    }


    public function create()
    {
        $db = DatabaseHelper::getConnection();
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/announcements/create.php';
    }

    public function store()
    {
        $db = DatabaseHelper::getConnection();

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $category = $_POST['category'] ?? 'info';
        $status = $_POST['status'] ?? 'draft';

        try {
            $stmt = $db->prepare("INSERT INTO announcements (title, content, category, status, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$title, $content, $category, $status]);

            header('Location: /admin/announcements?status=success');
            exit;
        } catch (\Exception $e) {
            die("Gagal menyimpan pengumuman: " . $e->getMessage());
        }
    }


    public function edit()
    {
        $db = DatabaseHelper::getConnection();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /admin/announcements');
            exit;
        }

        $stmt = $db->prepare("SELECT * FROM announcements WHERE id = ?");
        $stmt->execute([$id]);
        $announcement = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$announcement) {
            die("Pengumuman tidak ditemukan.");
        }

        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/announcements/edit.php';
    }

    public function update()
    {
        $db = DatabaseHelper::getConnection();

        $id = $_POST['id'];
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $category = $_POST['category'] ?? 'info';
        $status = $_POST['status'] ?? 'draft';

        try {
            $stmt = $db->prepare("UPDATE announcements SET title = ?, content = ?, category = ?, status = ? WHERE id = ?");
            $stmt->execute([$title, $content, $category, $status, $id]);

            header('Location: /admin/announcements?status=updated');
            exit;
        } catch (\Exception $e) {
            die("Gagal memperbarui pengumuman: " . $e->getMessage());
        }
    }

    public function delete()
    {
        $db = DatabaseHelper::getConnection();
        $id = $_GET['id'] ?? null;

        if ($id) {
            try {
                $stmt = $db->prepare("DELETE FROM announcements WHERE id = ?");
                $stmt->execute([$id]);
                header('Location: /admin/announcements?status=deleted');
                exit;
            } catch (\Exception $e) {
                die("Gagal menghapus data: " . $e->getMessage());
            }
        }
    }
}
