<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class AdminProductController
{
    public function adminIndex()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = DatabaseHelper::getConnection();

        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmtAdmin->execute(['id' => $_SESSION['user_id']]);
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        $allProducts = $db->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(\PDO::FETCH_ASSOC);

        require_once dirname(__DIR__, 2) . '/Views/admin/product/index.php';
    }

    public function store()
    {
        $this->saveProduct();
    }
    public function update()
    {
        $this->saveProduct($_POST['id']);
    }

    private function saveProduct($id = null)
    {
        $db = DatabaseHelper::getConnection();
        $uploadDir = 'assets/images/products/';
        $fullPath = __DIR__ . '/../../../public/' . $uploadDir;
        if (!is_dir($fullPath)) mkdir($fullPath, 0777, true);

        $photos = [];
        $videoPath = null;

        // Jika update, ambil data lama dulu
        if ($id) {
            $old = $db->query("SELECT photos, video_url FROM products WHERE id = $id")->fetch();
            $photos = json_decode($old['photos'], true) ?: [];
            $videoPath = $old['video_url'];
        }

        // Multi-upload Photos
        if (!empty($_FILES['photos']['name'][0])) {
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp) {
                $ext = pathinfo($_FILES['photos']['name'][$key], PATHINFO_EXTENSION);
                $newName = 'robot_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($tmp, $fullPath . $newName)) {
                    $photos[] = '/' . $uploadDir . $newName;
                }
            }
        }

        // Upload Video
        if (!empty($_FILES['video']['name'])) {
            $vidExt = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
            $vidName = 'vid_' . uniqid() . '.' . $vidExt;
            if (move_uploaded_file($_FILES['video']['tmp_name'], $fullPath . $vidName)) {
                $videoPath = '/' . $uploadDir . $vidName;
            }
        }

        if ($id) {
            $stmt = $db->prepare("UPDATE products SET name=?, category=?, price=?, description=?, photos=?, video_url=? WHERE id=?");
            $stmt->execute([$_POST['name'], $_POST['category'], $_POST['price'], $_POST['description'], json_encode($photos), $videoPath, $id]);
        } else {
            $stmt = $db->prepare("INSERT INTO products (name, category, price, description, photos, video_url) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$_POST['name'], $_POST['category'], $_POST['price'], $_POST['description'], json_encode($photos), $videoPath]);
        }
        header('Location: /admin/products?status=success');
    }

    public function edit()
    {
        $db = DatabaseHelper::getConnection();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo json_encode($stmt->fetch(\PDO::FETCH_ASSOC));
    }
}
