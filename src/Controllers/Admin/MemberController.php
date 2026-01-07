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
        $adminId = 3;

        // 1. Tangkap data dari URL (GET)
        $search = $_GET['search'] ?? '';
        $filter_divisi = $_GET['filter_divisi'] ?? '';
        $filter_generasi = $_GET['filter_generasi'] ?? ''; // ✅ Tambahkan ini
        $status_tab = $_GET['status'] ?? 'all';

        try {
            $db = DatabaseHelper::getConnection();

            // Ambil data Admin untuk Header
            $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtAdmin->execute(['id' => $adminId]);
            $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

            // 2. Bangun Query Dinamis
            $sql = "SELECT m.*, u.email, u.role 
                FROM members m 
                JOIN users u ON m.user_id = u.id 
                WHERE 1=1";

            $params = [];

            // Filter berdasarkan Tab (Active/Alumni)
            if (strtolower($status_tab) === 'active') {
                $sql .= " AND m.status_keanggotaan = 'Active'";
            } elseif (strtolower($status_tab) === 'alumni') {
                $sql .= " AND m.status_keanggotaan = 'Alumni'";
            }

            // Filter berdasarkan Input Pencarian
            if (!empty($search)) {
                $sql .= " AND (m.nama_lengkap ILIKE :search OR m.nim ILIKE :search)";
                $params['search'] = "%$search%";
            }

            // Filter berdasarkan Dropdown Divisi
            if (!empty($filter_divisi)) {
                $sql .= " AND m.divisi LIKE :divisi";
                $params['divisi'] = "%$filter_divisi%";
            }

            // ✅ Filter berdasarkan Generasi
            if (!empty($filter_generasi)) {
                $sql .= " AND m.generasi = :generasi";
                $params['generasi'] = $filter_generasi;
            }

            $sql .= " ORDER BY m.nama_lengkap ASC";

            // 3. Eksekusi Query
            $stmtMembers = $db->prepare($sql);
            $stmtMembers->execute($params);
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

        // 1. LOGIKA PENGGABUNGAN DIVISI
        $divisi1 = $_POST['divisi1'] ?? '';
        $divisi2 = $_POST['divisi2'] ?? '';
        $divisiFinal = (!empty($divisi2)) ? $divisi1 . ", " . $divisi2 : $divisi1;

        // 2. Ambil data sosial
        $socialData = $_POST['social'] ?? [];
        $socialLinksJson = json_encode($socialData);

        try {
            // --- LOGIKA UPDATE FOTO (TAMBAHAN) ---
            $fotoPath = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                // Path diarahkan ke public/assets/profiles (sesuaikan base path project Anda)
                // Biasanya di PHP, 'public/' adalah root folder web
                $uploadDir = 'assets/profiles/';
                $fullPath = __DIR__ . '/../../../public/' . $uploadDir; // Sesuaikan jumlah ../ dengan struktur folder Anda

                if (!is_dir($fullPath)) {
                    mkdir($fullPath, 0777, true);
                }

                $fileExtension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $fileName = 'profile_' . $_POST['nim'] . '_' . time() . '.' . $fileExtension;
                $destination = $fullPath . $fileName;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $destination)) {
                    $fotoPath = '/' . $uploadDir . $fileName;

                    // Opsional: Hapus foto lama agar tidak memenuhi storage
                    $stmtOld = $db->prepare("SELECT foto_url FROM members WHERE user_id = ?");
                    $stmtOld->execute([$id]);
                    $oldFoto = $stmtOld->fetchColumn();
                    if ($oldFoto && $oldFoto !== '/assets/images/memeng.jpg') {
                        $oldFotoSystemPath = __DIR__ . '/../../../public' . $oldFoto;
                        if (file_exists($oldFotoSystemPath)) {
                            unlink($oldFotoSystemPath);
                        }
                    }
                }
            }
            // ------------------------------------

            // 3. Update Tabel Members
            $sql = "UPDATE members SET 
                    nama_lengkap = ?, nim = ?, prodi = ?, angkatan = ?, 
                    generasi = ?, divisi = ?, jabatan = ?, status_keanggotaan = ?, 
                    bio = ?, skills = ?, social_links = ?, updated_at = NOW()";

            $params = [
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
            ];

            // Jika ada foto baru, tambahkan ke query
            if ($fotoPath) {
                $sql .= ", foto_url = ?";
                $params[] = $fotoPath;
            }

            $sql .= " WHERE user_id = ?";
            $params[] = $id;

            $stmt = $db->prepare($sql);
            $stmt->execute($params);

            // 4. Update Tabel Users (untuk Email)
            $stmtUser = $db->prepare("UPDATE users SET email = ? WHERE id = ?");
            $stmtUser->execute([$_POST['email'], $id]);

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
        try {
            $db = DatabaseHelper::getConnection();

            // 1. Ambil data dari form
            $nim = $_POST['nim'];
            $namaLengkap = $_POST['nama_lengkap'];
            $email = $_POST['email'];
            $prodi = $_POST['prodi'];
            $angkatan = $_POST['angkatan'] ?? date('Y');
            $generasi = $_POST['generasi'] ?? 1;
            $jabatan = $_POST['jabatan'] ?? 'Anggota';

            // Logika divisi
            $divisi1 = $_POST['divisi1'] ?? '';
            $divisi2 = $_POST['divisi2'] ?? '';
            $finalDivisi = $divisi1;

            if (!empty($divisi2) && $divisi2 === 'Humas' && $divisi1 !== 'Humas') {
                $finalDivisi = $divisi1 . ', ' . $divisi2;
            }

            // Bio & Skills
            $bio = $_POST['bio'] ?? '';
            $skills = $_POST['skills'] ?? '';

            // Social links
            $socialLinks = json_encode($_POST['social'] ?? []);

            // Handle foto
            $fotoPath = '/assets/images/memeng.jpg';
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/images/profiles/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileExtension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $fileName = 'profile_' . $nim . '_' . time() . '.' . $fileExtension;
                $destination = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $destination)) {
                    $fotoPath = '/' . $destination;
                }
            }

            $db->beginTransaction();

            // 2. Cek apakah buat akun login
            $userId = null;
            if (isset($_POST['create_account']) && $_POST['create_account']) {
                // Username dan Password = NIM
                $username = $nim;
                $password = $nim; // Password sama dengan NIM
                $role = $_POST['role'] ?? 'anggota';

                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert ke tabel users
                $stmtUser = $db->prepare("
                INSERT INTO users (username, email, password, role, is_active, created_at) 
                VALUES (:username, :email, :password, :role, TRUE, CURRENT_TIMESTAMP)
                RETURNING id
            ");

                $stmtUser->execute([
                    'username' => $username,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'role' => $role
                ]);

                $userRow = $stmtUser->fetch(\PDO::FETCH_ASSOC);
                $userId = $userRow['id'];
            }

            // 3. Insert ke tabel members
            $stmtMember = $db->prepare("
            INSERT INTO members (
                user_id, nama_lengkap, nim, prodi, angkatan, generasi, 
                divisi, jabatan, bio, skills, social_links, foto_url, 
                status_keanggotaan, created_at
            ) VALUES (
                :user_id, :nama_lengkap, :nim, :prodi, :angkatan, :generasi,
                :divisi, :jabatan, :bio, :skills, :social_links, :foto_url,
                'active', CURRENT_TIMESTAMP
            )
        ");

            $stmtMember->execute([
                'user_id' => $userId,
                'nama_lengkap' => $namaLengkap,
                'nim' => $nim,
                'prodi' => $prodi,
                'angkatan' => $angkatan,
                'generasi' => $generasi,
                'divisi' => $finalDivisi,
                'jabatan' => $jabatan,
                'bio' => $bio,
                'skills' => $skills,
                'social_links' => $socialLinks,
                'foto_url' => $fotoPath
            ]);

            $db->commit();

            header('Location: /admin/members?status=success&msg=created');
            exit;
        } catch (\PDOException $e) {
            if (isset($db)) {
                $db->rollBack();
            }
            die("Gagal menyimpan data: " . $e->getMessage());
        }
    }
}
