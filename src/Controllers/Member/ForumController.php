<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class ForumController
{
    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Tampilkan Daftar Topik
    public function index()
    {
        $this->startSession();
        $userId = 2; // Bypass sementara

        try {
            $db = DatabaseHelper::getConnection();

            // Data User untuk Navbar
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // Data Forum Posts
            $stmtPosts = $db->query("
                SELECT f.*, m.nama_lengkap, 
                (SELECT COUNT(*) FROM forum_comments WHERE post_id = f.id) as comment_count 
                FROM forum_posts f 
                JOIN members m ON f.user_id = m.user_id 
                ORDER BY f.created_at DESC
            ");
            $posts = $stmtPosts->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/member-area/forum/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }

    // Tampilkan Halaman Buat Topik Baru
    public function create()
    {
        $this->startSession();
        $userId = 2;

        $db = DatabaseHelper::getConnection();
        $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmtUser->execute(['id' => $userId]);
        $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/member-area/forum/create.php';
    }

    // Simpan Topik Baru ke Database
    public function store()
    {
        $this->startSession();
        $userId = 2;

        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? 'Discussion';
        $content = $_POST['content'] ?? '';

        try {
            $db = DatabaseHelper::getConnection();
            $stmt = $db->prepare("
                INSERT INTO forum_posts (user_id, title, content, category, created_at) 
                VALUES (:uid, :title, :content, :category, CURRENT_TIMESTAMP)
            ");
            $stmt->execute([
                'uid' => $userId,
                'title' => $title,
                'content' => $content,
                'category' => $category
            ]);

            header('Location: /member/forum');
            exit;
        } catch (\PDOException $e) {
            die("Gagal menyimpan topik: " . $e->getMessage());
        }
    }

    // Tampilkan Detail Topik dan Komentar
    public function detail()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userId = 2; // Bypass ID 2
        $postId = $_GET['id'] ?? null;

        if (!$postId) {
            header('Location: /member/forum');
            exit;
        }

        try {
            $db = \App\Helpers\DatabaseHelper::getConnection();

            // PERBAIKAN: Tambahkan user_id ke dalam SELECT
            $stmtUser = $db->prepare("SELECT user_id, nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // Ambil Detail Post
            $stmtPost = $db->prepare("
            SELECT f.*, m.nama_lengkap, m.foto_url 
            FROM forum_posts f 
            JOIN members m ON f.user_id = m.user_id 
            WHERE f.id = :pid
        ");
            $stmtPost->execute(['pid' => $postId]);
            $post = $stmtPost->fetch(\PDO::FETCH_ASSOC);

            // Ambil Daftar Komentar
            $stmtComm = $db->prepare("
            SELECT c.*, m.nama_lengkap, m.foto_url 
            FROM forum_comments c 
            JOIN members m ON c.user_id = m.user_id 
            WHERE c.post_id = :pid 
            ORDER BY c.created_at ASC
        ");
            $stmtComm->execute(['pid' => $postId]);
            $comments = $stmtComm->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/member-area/forum/detail.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }

    public function storeComment()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userId = 2; // ID bypass sementara

        $postId = $_POST['post_id'] ?? null;
        $comment = $_POST['comment'] ?? '';

        if ($postId && !empty($comment)) {
            try {
                $db = \App\Helpers\DatabaseHelper::getConnection();
                $stmt = $db->prepare("
                INSERT INTO forum_comments (post_id, user_id, comment, created_at) 
                VALUES (:pid, :uid, :comment, CURRENT_TIMESTAMP)
            ");
                $stmt->execute([
                    'pid' => $postId,
                    'uid' => $userId,
                    'comment' => $comment
                ]);

                // Redirect kembali ke halaman detail topik yang sama
                header('Location: /member/forum/detail?id=' . $postId);
                exit;
            } catch (\PDOException $e) {
                die("Gagal mengirim komentar: " . $e->getMessage());
            }
        } else {
            header('Location: /member/forum');
            exit;
        }
    }
}
