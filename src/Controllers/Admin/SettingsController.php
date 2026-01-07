<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class SettingsController
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

        // 1. Ambil Pengaturan Situs
        $settings = $db->query("SELECT * FROM site_settings LIMIT 1")->fetch(\PDO::FETCH_ASSOC);

        // 2. Ambil Daftar Admin (Pastikan nilai IN sesuai ENUM: 'admin', 'superadmin', dsb)
        // Saya asumsikan ENUM Anda adalah 'admin' dan 'anggota'
        $admins = $db->query("SELECT u.id, u.email, u.role, m.nama_lengkap 
                         FROM users u 
                         JOIN members m ON u.id = m.user_id 
                         WHERE u.role != 'anggota'
                         ORDER BY u.role DESC")->fetchAll(\PDO::FETCH_ASSOC);

        // 3. Ambil Anggota Biasa (Ganti 'member' menjadi 'anggota')
        $availableMembers = $db->query("SELECT u.id, m.nama_lengkap, m.nim 
                                   FROM users u 
                                   JOIN members m ON u.id = m.user_id 
                                   WHERE u.role = 'anggota' 
                                   ORDER BY m.nama_lengkap ASC")->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/settings/index.php';
    }

    /**
     * Menambahkan Akses Admin ke User (Ganti Role)
     */
    public function addAdmin()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();
        $userId = $_POST['user_id'] ?? null;
        $role = $_POST['role'] ?? 'admin'; // Pastikan 'admin' ada di ENUM

        if ($userId) {
            $stmt = $db->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$role, $userId]);
            header('Location: /admin/settings?status=admin_added');
        }
        exit;
    }

    public function deleteAdmin()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();
        $userId = $_GET['id'] ?? null;

        if ($userId) {
            // Ganti 'member' menjadi 'anggota' sesuai skema ENUM Anda
            $stmt = $db->prepare("UPDATE users SET role = 'anggota' WHERE id = ?");
            $stmt->execute([$userId]);
            header('Location: /admin/settings?status=admin_removed');
        }
        exit;
    }

    public function updateGeneral()
    {
        $db = DatabaseHelper::getConnection();
        $siteName = $_POST['site_name'] ?? 'EEPROM POLINEMA';
        $tagline = $_POST['site_tagline'] ?? '';
        $maintenance = isset($_POST['maintenance_mode']) ? 'true' : 'false';

        // Cek data ada atau tidak
        $exists = $db->query("SELECT id FROM site_settings LIMIT 1")->fetch();

        if ($exists) {
            $stmt = $db->prepare("UPDATE site_settings SET site_name = ?, site_tagline = ?, maintenance_mode = ? WHERE id = ?");
            $stmt->execute([$siteName, $tagline, $maintenance, $exists['id']]);
        } else {
            $stmt = $db->prepare("INSERT INTO site_settings (site_name, site_tagline, maintenance_mode) VALUES (?, ?, ?)");
            $stmt->execute([$siteName, $tagline, $maintenance]);
        }

        header('Location: /admin/settings?status=updated');
        exit;
    }
}
