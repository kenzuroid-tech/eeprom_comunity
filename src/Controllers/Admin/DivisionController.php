<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class DivisionController
{
    public function index()
    {
        $db = DatabaseHelper::getConnection();

        // 1. Ambil data admin untuk header
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        // 2. Query untuk mengambil daftar divisi dan menghitung jumlah anggotanya
        // Menggunakan LEFT JOIN agar divisi tanpa anggota tetap muncul
        $stmtDiv = $db->query("
            SELECT d.*, 
            (SELECT COUNT(*) FROM members m WHERE m.divisi LIKE '%' || d.name || '%') as member_count
            FROM divisions d
            ORDER BY d.sort_order ASC
        ");
        $divisions = $stmtDiv->fetchAll(\PDO::FETCH_ASSOC);

        // 3. Statistik Ringkas
        $totalMembers = array_sum(array_column($divisions, 'member_count'));
        $totalDivisions = count($divisions);
        usort($divisions, fn($a, $b) => $b['member_count'] <=> $a['member_count']);
        $largestDivision = $divisions[0]['name'] ?? '-';

        require_once __DIR__ . '/../../Views/admin/divisions/index.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $db = \App\Helpers\DatabaseHelper::getConnection();

        // Ambil data divisi
        $stmt = $db->prepare("SELECT * FROM divisions WHERE id = ?");
        $stmt->execute([$id]);
        $division = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$division) die("Divisi tidak ditemukan.");

        // Data admin untuk navbar
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/divisions/edit.php';
    }

    public function update()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $old_icon = $_POST['old_icon'];

        $iconPath = $old_icon; // Default gunakan ikon lama

        // Logika Upload Foto jika ada file baru yang diunggah
        // Bagian di dalam method update()
        if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
            // Gunakan path relatif dari index.php (public folder)
            $uploadDir = 'assets/images/icons/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileExtension = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
            $fileName = strtolower(str_replace(' ', '_', $name)) . '_' . time() . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['icon']['tmp_name'], $targetPath)) {
                // Simpan path diawali '/' agar router bisa membaca dari root domain
                $iconPath = '/' . $targetPath;
            }
        }

        // Update data divisi
        $stmt = $db->prepare("UPDATE divisions SET name = ?, description = ?, icon = ? WHERE id = ?");
        $stmt->execute([$name, $description, $iconPath, $id]);

        // Redirect kembali ke halaman daftar divisi
        header('Location: /admin/divisions');
        exit;
    }
}
