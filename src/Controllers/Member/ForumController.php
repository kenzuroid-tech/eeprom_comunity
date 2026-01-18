<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper;

class ForumController
{
    // Helper untuk memastikan user sudah login dan mengambil ID-nya
    private function getLoggedInUserId()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        return $_SESSION['user_id'];
    }

    // Tampilkan Daftar Topik
    public function index()
    {
        $userId = $this->getLoggedInUserId();

        try {
            $db = DatabaseHelper::getConnection();

            // Data User untuk Navbar
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

            // Sesuaikan variabel agar seragam di semua View (Navbar biasanya pakai $fotoPath atau $userFoto)
            $fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';
            $userFoto = $fotoPath; // Support kedua nama variabel jika diperlukan

            // Data Forum Posts dengan Nama Penulis dan Jumlah Komentar
            $stmtPosts = $db->query("
                SELECT f.*, m.nama_lengkap, m.foto_url as author_photo,
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
        $userId = $this->getLoggedInUserId();

        $db = DatabaseHelper::getConnection();
        $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmtUser->execute(['id' => $userId]);
        $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);

        $fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';
        $userFoto = $fotoPath;

        require_once __DIR__ . '/../../Views/member-area/forum/create.php';
    }

    // Simpan Topik Baru ke Database
    public function store()
    {
        $userId = $this->getLoggedInUserId();

        // Validasi input sederhana
        $title = trim($_POST['title'] ?? '');
        $category = $_POST['category'] ?? 'Discussion';
        $content = trim($_POST['content'] ?? '');

        if (empty($title) || empty($content)) {
            header('Location: /member/forum/create?status=error&msg=empty_fields');
            exit;
        }

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

            header('Location: /member/forum?status=success&msg=topic_created');
            exit;
        } catch (\PDOException $e) {
            die("Gagal menyimpan topik: " . $e->getMessage());
        }
    }

    // Tampilkan Detail Topik dan Komentar
    public function detail()
    {
        $userId = $this->getLoggedInUserId();
        $postId = $_GET['id'] ?? null;

        if (!$postId) {
            header('Location: /member/forum');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            // Data User Login (untuk Navbar)
            $stmtUser = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtUser->execute(['id' => $userId]);
            $userData = $stmtUser->fetch(\PDO::FETCH_ASSOC);
            $fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : '/assets/images/default-avatar.png';
            $userFoto = $fotoPath;

            // Ambil Detail Post beserta data penulisnya
            $stmtPost = $db->prepare("
                SELECT f.*, m.nama_lengkap, m.foto_url as author_photo 
                FROM forum_posts f 
                JOIN members m ON f.user_id = m.user_id 
                WHERE f.id = :pid
            ");
            $stmtPost->execute(['pid' => $postId]);
            $post = $stmtPost->fetch(\PDO::FETCH_ASSOC);

            if (!$post) {
                die("Topik tidak ditemukan.");
            }

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
        $userId = $this->getLoggedInUserId();

        $postId = $_POST['post_id'] ?? null;
        $comment = trim($_POST['comment'] ?? '');

        if ($postId && !empty($comment)) {
            try {
                $db = DatabaseHelper::getConnection();
                $stmt = $db->prepare("
                    INSERT INTO forum_comments (post_id, user_id, comment, created_at) 
                    VALUES (:pid, :uid, :comment, CURRENT_TIMESTAMP)
                ");
                $stmt->execute([
                    'pid' => $postId,
                    'uid' => $userId,
                    'comment' => $comment
                ]);

                header('Location: /member/forum/detail?id=' . $postId . '&status=success#comments');
                exit;
            } catch (\PDOException $e) {
                die("Gagal mengirim komentar: " . $e->getMessage());
            }
        } else {
            header('Location: /member/forum/detail?id=' . $postId . '&status=error');
            exit;
        }
    }
}