<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class MemberController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $adminId = 3; // Bypass Admin ID

        try {
            $db = DatabaseHelper::getConnection();

            // 1. Ambil data Admin untuk Header
            $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtAdmin->execute(['id' => $adminId]);
            $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

            // 2. Ambil Daftar Anggota
            // Kita JOIN dengan users untuk mendapatkan email/role jika perlu
            $stmtMembers = $db->query("
                SELECT m.*, u.email, u.role 
                FROM members m 
                JOIN users u ON m.user_id = u.id 
                ORDER BY m.nama_lengkap ASC
            ");
            $allMembers = $stmtMembers->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/admin/members/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin/members');
            exit;
        }

        $db = \App\Helpers\DatabaseHelper::getConnection();
        // Ambil data anggota dan user
        $stmt = $db->prepare("
        SELECT 
            m.user_id, m.nama_lengkap, m.nim, m.prodi, m.angkatan, 
            m.generasi, m.divisi, m.jabatan, m.status_keanggotaan, 
            m.foto_url, m.bio, m.social_links, m.skills, u.email 
        FROM members m 
        JOIN users u ON m.user_id = u.id 
        WHERE m.user_id = :id
    ");
        $stmt->execute(['id' => $id]);
        $member = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$member) {
            die("Anggota tidak ditemukan.");
        }

        // Ambil data admin untuk navbar
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/members/edit.php';
    }

    public function update()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();

        // Ambil ID User
        $id = $_POST['user_id'];

        // LOGIKA PENGGABUNGAN DIVISI (Utama & Tambahan)
        $divisi1 = $_POST['divisi1'] ?? '';
        $divisi2 = $_POST['divisi2'] ?? '';
        $divisiFinal = (!empty($divisi2)) ? $divisi1 . ", " . $divisi2 : $divisi1;

        // Ambil data sosial dan encode ke JSONB (Termasuk WhatsApp)
        $socialData = $_POST['social'] ?? [];
        $socialLinksJson = json_encode($socialData);

        try {
            // 1. Update Tabel Members
            $stmt = $db->prepare("
            UPDATE members SET 
                nama_lengkap = ?, nim = ?, prodi = ?, angkatan = ?, 
                generasi = ?, divisi = ?, jabatan = ?, status_keanggotaan = ?, 
                bio = ?, skills = ?, social_links = ?, updated_at = NOW()
            WHERE user_id = ?
        ");

            $stmt->execute([
                $_POST['nama_lengkap'],
                $_POST['nim'],
                $_POST['prodi'],
                $_POST['angkatan'],
                $_POST['generasi'],
                $divisiFinal,
                $_POST['jabatan'],
                $_POST['status_keanggotaan'],
                $_POST['bio'],
                $_POST['skills'],
                $socialLinksJson,
                $id
            ]);

            // 2. Update Tabel Users (untuk Email)
            $stmtUser = $db->prepare("UPDATE users SET email = ? WHERE id = ?");
            $stmtUser->execute([$_POST['email'], $id]);

            // Redirect kembali ke daftar member dengan pesan sukses
            header('Location: /admin/members?status=updated');
            exit;
        } catch (\Exception $e) {
            die("Gagal memperbarui data: " . $e->getMessage());
        }
    }

    public function create()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();
        // Ambil data admin untuk navbar
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = 3");
        $stmtAdmin->execute();
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/members/create.php';
    }

    public function store()
    {
        $db = \App\Helpers\DatabaseHelper::getConnection();

        // 1. Data untuk tabel Users (Login)
        $username = $_POST['nim']; // Gunakan NIM sebagai username default
        $email = $_POST['email'];
        $password = password_hash('EEPROM' . $_POST['nim'], PASSWORD_BCRYPT); // Password default: EEPROM + NIM
        $role = 'anggota';

        // 2. Data untuk tabel Members (Profil)
        $divisi1 = $_POST['divisi1'] ?? '';
        $divisi2 = $_POST['divisi2'] ?? '';
        $divisiFinal = (!empty($divisi2)) ? $divisi1 . ", " . $divisi2 : $divisi1;
        $socialLinksJson = json_encode($_POST['social'] ?? []);

        try {
            $db->beginTransaction();

            // Insert ke tabel Users
            $stmtUser = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?) RETURNING id");
            $stmtUser->execute([$username, $email, $password, $role]);
            $newUserId = $stmtUser->fetchColumn();

            // Insert ke tabel Members
            $stmtMember = $db->prepare("
            INSERT INTO members (user_id, nama_lengkap, nim, prodi, angkatan, generasi, divisi, jabatan, status_keanggotaan, bio, skills, social_links)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

            $stmtMember->execute([
                $newUserId,
                $_POST['nama_lengkap'],
                $_POST['nim'],
                $_POST['prodi'],
                $_POST['angkatan'],
                $_POST['generasi'],
                $divisiFinal,
                $_POST['jabatan'],
                $_POST['status_keanggotaan'],
                $_POST['bio'],
                $_POST['skills'],
                $socialLinksJson
            ]);

            $db->commit();
            header('Location: /admin/members?status=created');
        } catch (\Exception $e) {
            $db->rollBack();
            die("Gagal menambah anggota: " . $e->getMessage());
        }
    }
}
