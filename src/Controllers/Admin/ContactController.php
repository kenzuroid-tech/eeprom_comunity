<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class ContactController
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

        $messages = $db->query("SELECT * FROM contacts ORDER BY created_at DESC")->fetchAll(\PDO::FETCH_ASSOC);
        $mainContact = $db->query("SELECT * FROM organization_contact LIMIT 1")->fetch(\PDO::FETCH_ASSOC);
        $contactPersons = $db->query("SELECT * FROM contact_persons ORDER BY sort_order ASC")->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/contacts/index.php';
    }

    public function updateMain()
    {
        $db = DatabaseHelper::getConnection();
        $data = [
            $_POST['address'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['whatsapp'],
            $_POST['instagram'],
            $_POST['maps_code']
        ];

        $check = $db->query("SELECT id FROM organization_contact LIMIT 1")->fetch();

        if ($check) {
            $sql = "UPDATE organization_contact SET address=?, email=?, phone=?, whatsapp=?, instagram=?, maps_code=? WHERE id=?";
            $data[] = $check['id'];
        } else {
            $sql = "INSERT INTO organization_contact (address, email, phone, whatsapp, instagram, maps_code) VALUES (?, ?, ?, ?, ?, ?)";
        }

        $db->prepare($sql)->execute($data);
        header('Location: /admin/contacts?status=updated');
    }

    public function saveCP()
    {
        $db = DatabaseHelper::getConnection();
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'];
        $position = $_POST['position'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $sort_order = $_POST['sort_order'] ?? 0;

        $photo_url = null;

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            // Perbaikan Path: Menggunakan DOCUMENT_ROOT agar mengarah ke folder public
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/contacts/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('cp_') . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                $photo_url = '/assets/images/contacts/' . $fileName;
            }
        }

        if ($id) {
            if ($photo_url) {
                $sql = "UPDATE contact_persons SET name=?, position=?, email=?, phone=?, sort_order=?, photo_url=? WHERE id=?";
                $params = [$name, $position, $email, $phone, $sort_order, $photo_url, $id];
            } else {
                $sql = "UPDATE contact_persons SET name=?, position=?, email=?, phone=?, sort_order=? WHERE id=?";
                $params = [$name, $position, $email, $phone, $sort_order, $id];
            }
        } else {
            $sql = "INSERT INTO contact_persons (name, position, email, phone, sort_order, photo_url) VALUES (?, ?, ?, ?, ?, ?)";
            $params = [$name, $position, $email, $phone, $sort_order, $photo_url];
        }

        $db->prepare($sql)->execute($params);
        header('Location: /admin/contacts?tab=cp&status=saved');
    }

    public function deleteCP()
    {
        $db = DatabaseHelper::getConnection();
        $id = $_GET['id'];

        $cp = $db->prepare("SELECT photo_url FROM contact_persons WHERE id = ?");
        $cp->execute([$id]);
        $data = $cp->fetch();

        if ($data && $data['photo_url']) {
            // Perbaikan: Hapus file menggunakan path fisik server
            $physicalPath = $_SERVER['DOCUMENT_ROOT'] . $data['photo_url'];
            if (file_exists($physicalPath) && is_file($physicalPath)) {
                unlink($physicalPath);
            }
        }

        $db->prepare("DELETE FROM contact_persons WHERE id = ?")->execute([$id]);
        header('Location: /admin/contacts?tab=cp&status=deleted');
    }
}