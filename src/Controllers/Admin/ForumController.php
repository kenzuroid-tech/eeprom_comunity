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

    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin/forum');
            exit;
        }

        $db = \App\Helpers\DatabaseHelper::getConnection();

        // 1. Ambil Detail Postingan
        $stmt = $db->prepare("
        SELECT fp.*, m.nama_lengkap, m.foto_url, m.jabatan 
        FROM forum_posts fp 
        JOIN members m ON fp.user_id = m.user_id 
        WHERE fp.id = :id
    ");
        $stmt->execute(['id' => $id]);
        $post = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$post) {
            die("Postingan tidak ditemukan.");
        }

        // 2. Ambil Komentar/Balasan
        $stmtComments = $db->prepare("
        SELECT fc.*, m.nama_lengkap, m.foto_url 
        FROM forum_comments fc 
        JOIN members m ON fc.user_id = m.user_id 
        WHERE fc.post_id = :id 
        ORDER BY fc.created_at ASC
    ");
        $stmtComments->execute(['id' => $id]);
        $comments = $stmtComments->fetchAll(\PDO::FETCH_ASSOC);

        // 3. Data Admin untuk Navbar
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :admin_id");
        $stmtAdmin->execute(['admin_id' => $_SESSION['user_id']]);
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/forum/detail.php';
    }

    public function create()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();

        // Ambil data admin untuk navbar (Helper function yang sudah Anda miliki)
        $adminData = $this->getAdminData($db);

        // Load view create milik admin
        require_once __DIR__ . '/../../Views/admin/forum/create.php';
    }

    public function store()
    {
        // Mendukung input JSON dari Fetch API (seperti yang kita buat sebelumnya)
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // Jika data kosong (karena pengiriman form biasa), ambil dari $_POST
        $title = $data['title'] ?? $_POST['title'] ?? null;
        $content = $data['content'] ?? $_POST['content'] ?? null;
        $category = $data['category'] ?? $_POST['category'] ?? null;

        if (!$title || !$content || !$category) {
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Data tidak lengkap."]);
            return;
        }

        try {
            $db = DatabaseHelper::getConnection();
            if (session_status() === PHP_SESSION_NONE) session_start();
            $userId = $_SESSION['user_id'];

            $stmt = $db->prepare("INSERT INTO forum_posts (user_id, title, content, category, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$userId, $title, $content, $category]);

            header('Content-Type: application/json');
            echo json_encode(["success" => true, "message" => "Topik berhasil diterbitkan!"]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Gagal menyimpan: " . $e->getMessage()]);
        }
    }
}
