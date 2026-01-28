<?php

namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class MemberController
{
    /**
     * Menampilkan daftar anggota dengan filter role sesuai hierarki
     */
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $adminId = $_SESSION['user_id'] ?? 0;
        $adminRole = $_SESSION['role'] ?? 'admin';

        $search = $_GET['search'] ?? '';
        $filter_divisi = $_GET['filter_divisi'] ?? '';
        $filter_generasi = $_GET['filter_generasi'] ?? '';
        $status_tab = $_GET['status'] ?? 'all';

        try {
            $db = DatabaseHelper::getConnection();

            // Ambil data profil admin untuk navbar
            $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
            $stmtAdmin->execute(['id' => $adminId]);
            $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

            // Query Dasar
            $sql = "SELECT m.*, u.email as account_email, u.role 
                    FROM members m 
                    LEFT JOIN users u ON m.user_id = u.id 
                    WHERE 1=1";

            // LOGIKA HIERARKI ROLE:
            // Admin biasa dilarang melihat Admin lain dan Superadmin
            if ($adminRole === 'admin') {
                $sql .= " AND u.role NOT IN ('admin', 'superadmin')";
            }
            // Superadmin bisa melihat semuanya (tanpa filter role tambahan)

            $params = [];

            if (strtolower($status_tab) === 'active') {
                $sql .= " AND m.status_keanggotaan = 'Active'";
            } elseif (strtolower($status_tab) === 'alumni') {
                $sql .= " AND m.status_keanggotaan = 'Alumni'";
            }

            if (!empty($search)) {
                $sql .= " AND (m.nama_lengkap ILIKE :search OR m.nim ILIKE :search)";
                $params['search'] = "%$search%";
            }

            if (!empty($filter_divisi)) {
                $sql .= " AND m.divisi LIKE :divisi";
                $params['divisi'] = "%$filter_divisi%";
            }

            if (!empty($filter_generasi)) {
                $sql .= " AND m.generasi = :generasi";
                $params['generasi'] = $filter_generasi;
            }

            $sql .= " ORDER BY m.nama_lengkap ASC";

            $stmtMembers = $db->prepare($sql);
            $stmtMembers->execute($params);
            $allMembers = $stmtMembers->fetchAll(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/admin/members/index.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }

    /**
     * Menyimpan data anggota baru (Mendukung Role Baru)
     */
    public function store()
    {
        try {
            $db = DatabaseHelper::getConnection();
            $db->beginTransaction();

            $nim = $_POST['nim'];
            $email = $_POST['email'];
            $role = $_POST['role'] ?? 'anggota'; // role: admin, anggota, alumni, superadmin
            $angkatan = (int)($_POST['angkatan'] ?? date('Y'));
            $generasi = (int)($_POST['generasi'] ?? 1);

            // Logika divisi
            $divisi1 = $_POST['divisi1'] ?? '';
            $divisi2 = $_POST['divisi2'] ?? '';
            $finalDivisi = (!empty($divisi2)) ? $divisi1 . ", " . $divisi2 : $divisi1;

            // Handle Foto (Default logic)
            $fotoPath = '/assets/images/profile.jpg';
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/images/profiles/';
                $fullPath = __DIR__ . '/../../../public/' . $uploadDir;
                if (!is_dir($fullPath)) mkdir($fullPath, 0777, true);
                $fileName = 'profile_' . $nim . '_' . time() . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $fullPath . $fileName)) {
                    $fotoPath = '/' . $uploadDir . $fileName;
                }
            }

            $userId = null;
            if (isset($_POST['create_account'])) {
                $hashedPassword = password_hash($nim, PASSWORD_DEFAULT);
                $stmtUser = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?) RETURNING id");
                $stmtUser->execute([$nim, $email, $hashedPassword, $role]);
                $userId = $stmtUser->fetchColumn();
            }

            $stmtMember = $db->prepare("INSERT INTO members (user_id, nama_lengkap, nim, email, prodi, angkatan, generasi, divisi, jabatan, bio, skills, social_links, foto_url, status_keanggotaan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtMember->execute([
                $userId,
                $_POST['nama_lengkap'],
                $nim,
                $email,
                $_POST['prodi'],
                $angkatan,
                $generasi,
                $finalDivisi,
                $_POST['jabatan'],
                $_POST['bio'] ?? '',
                $_POST['skills'] ?? '',
                json_encode($_POST['social'] ?? []),
                $fotoPath,
                ($role === 'alumni' ? 'Alumni' : 'Active')
            ]);

            $db->commit();
            header('Location: /admin/members?status=success');
        } catch (\Exception $e) {
            if (isset($db)) $db->rollBack();
            die("Gagal menyimpan data: " . $e->getMessage());
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        $myRole = $_SESSION['role'];
        $myId = $_SESSION['user_id'];

        if ($id == $myId) {
            header('Location: /admin/members?status=error&msg=self_delete');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            $stmtData = $db->prepare("SELECT role FROM users WHERE id = :id");
            $stmtData->execute(['id' => $id]);
            $target = $stmtData->fetch(\PDO::FETCH_ASSOC);

            if (!$target) {
                header('Location: /admin/members?status=error&msg=not_found');
                exit;
            }

            // PROTEKSI: Admin biasa tidak boleh hapus sesama Admin atau Superadmin
            if ($myRole === 'admin' && ($target['role'] === 'admin' || $target['role'] === 'superadmin')) {
                header('Location: /admin/members?status=error&msg=unauthorized');
                exit;
            }

            $stmtDelete = $db->prepare("DELETE FROM users WHERE id = :id");
            $stmtDelete->execute(['id' => $id]);

            header('Location: /admin/members?status=deleted');
            exit;
        } catch (\PDOException $e) {
            die("Gagal menghapus data: " . $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit anggota
     */
    public function edit()
    {
        $id = $_GET['id'] ?? null; // Ini adalah members.id
        if (!$id) {
            header('Location: /admin/members');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();

            // Cari berdasarkan members.id (PK Tabel Members)
            $stmt = $db->prepare("
            SELECT m.*, u.email as account_email, u.role 
            FROM members m 
            LEFT JOIN users u ON m.user_id = u.id 
            WHERE m.id = :id
        ");
            $stmt->execute(['id' => $id]);
            $member = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$member) {
                die("Anggota tidak ditemukan.");
            }

            // Ambil data admin login untuk navbar
            $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :admin_id");
            $stmtAdmin->execute(['admin_id' => $_SESSION['user_id']]);
            $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../../Views/admin/members/edit.php';
        } catch (\PDOException $e) {
            die("Error Database: " . $e->getMessage());
        }
    }

    public function create()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $db = DatabaseHelper::getConnection();
        $stmtAdmin = $db->prepare("SELECT nama_lengkap, foto_url FROM members WHERE user_id = :id");
        $stmtAdmin->execute(['id' => $_SESSION['user_id']]);
        $adminData = $stmtAdmin->fetch(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../Views/admin/members/create.php';
    }

    public function resetPassword()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Keamanan: Hanya Superadmin yang boleh akses fungsi ini
        if ($_SESSION['role'] !== 'superadmin') {
            header('Location: /admin/members?status=error&msg=unauthorized');
            exit;
        }

        $id = $_POST['user_id'];
        $newPass = $_POST['new_password'];

        try {
            $db = DatabaseHelper::getConnection();

            // Enkripsi password baru sebelum disimpan
            $hash = password_hash($newPass, PASSWORD_DEFAULT);

            $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hash, $id]);

            // Kembali ke halaman edit dengan pesan sukses
            header('Location: /admin/members/edit?id=' . $id . '&status=reset_success');
            exit;
        } catch (\Exception $e) {
            die("Gagal reset password: " . $e->getMessage());
        }
    }

    /**
     * Memperbarui data anggota dan sinkronisasi ke tabel users
     */
    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $db = DatabaseHelper::getConnection();

        // Ambil data dari POST
        $user_id = $_POST['user_id'] ?? null;
        $member_id = $_POST['member_id'] ?? null; // PK Utama tabel members
        $role = $_POST['role'] ?? 'anggota';
        $email = $_POST['email'];

        // Validasi dasar: Jika member_id kosong, hentikan proses
        if (!$member_id) {
            die("ID Anggota tidak valid.");
        }

        // Casting integer
        $angkatan = (int)$_POST['angkatan'];
        $generasi = (int)$_POST['generasi'];

        // Logika penggabungan divisi
        $divisi1 = $_POST['divisi1'] ?? '';
        $divisi2 = $_POST['divisi2'] ?? '';
        $divisiFinal = (!empty($divisi2)) ? $divisi1 . ", " . $divisi2 : $divisi1;

        $socialLinksJson = json_encode($_POST['social'] ?? []);

        try {
            $db->beginTransaction();

            // 1. Handle Upload Foto
            $fotoPath = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/images/profiles/';
                $fullPath = __DIR__ . '/../../../public/' . $uploadDir;
                if (!is_dir($fullPath)) mkdir($fullPath, 0777, true);

                $fileName = 'profile_update_' . $member_id . '_' . time() . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $fullPath . $fileName)) {
                    $fotoPath = '/' . $uploadDir . $fileName;
                }
            }

            // 2. Query Update tabel members
            // PERBAIKAN: Gunakan 'id' (PK members) bukan 'user_id' agar data tidak tertukar
            $sql = "UPDATE members SET 
                nama_lengkap = ?, nim = ?, email = ?, prodi = ?, angkatan = ?, 
                generasi = ?, divisi = ?, jabatan = ?, status_keanggotaan = ?, 
                bio = ?, social_links = ?, updated_at = NOW()";

            $params = [
                $_POST['nama_lengkap'],
                $_POST['nim'],
                $email,
                $_POST['prodi'],
                $angkatan,
                $generasi,
                $divisiFinal,
                $_POST['jabatan'],
                $_POST['status_keanggotaan'],
                $_POST['bio'],
                $socialLinksJson
            ];

            if ($fotoPath) {
                $sql .= ", foto_url = ?";
                $params[] = $fotoPath;
            }

            $sql .= " WHERE id = ?";
            $params[] = $member_id;

            $stmt = $db->prepare($sql);
            $stmt->execute($params);

            // 3. Sinkronisasi ke tabel users (Hanya jika user_id tersedia/tidak NULL)
            if (!empty($user_id) && $user_id !== 'NULL' && $user_id !== '') {
                $stmtUser = $db->prepare("UPDATE users SET email = ?, role = ?, updated_at = NOW() WHERE id = ?");
                $stmtUser->execute([$email, $role, $user_id]);
            }

            $db->commit();
            header('Location: /admin/members?status=updated');
            exit;
        } catch (\Exception $e) {
            if (isset($db)) $db->rollBack();
            die("Gagal memperbarui data: " . $e->getMessage());
        }
    }

    /**
     * Menghapus banyak anggota sekaligus
     */
    public function bulkDelete()
    {
        $ids = $_POST['ids'] ?? [];
        if (empty($ids)) {
            header('Location: /admin/members');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();
            $db->beginTransaction();

            // Proteksi: Jangan biarkan admin menghapus dirinya sendiri atau Superadmin dalam bulk
            $placeholders = str_repeat('?,', count($ids) - 1) . '?';
            $sql = "DELETE FROM users WHERE id IN ($placeholders) AND role NOT IN ('superadmin')";

            $stmt = $db->prepare($sql);
            $stmt->execute($ids);

            $db->commit();
            header('Location: /admin/members?status=deleted');
        } catch (\Exception $e) {
            if (isset($db)) $db->rollBack();
            die("Gagal hapus massal: " . $e->getMessage());
        }
    }

    public function bulkAlumni()
    {
        $ids = $_POST['ids'] ?? [];
        if (empty($ids)) {
            header('Location: /admin/members?status=no_selection');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();
            $db->beginTransaction();

            // Membuat string placeholder ?,?,? sebanyak jumlah ID
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

            // 1. Update tabel members (status keanggotaan)
            $stmt1 = $db->prepare("UPDATE members SET status_keanggotaan = 'Alumni' WHERE user_id IN ($placeholders)");
            $stmt1->execute($ids);

            // 2. Update tabel users (role login)
            // Catatan: Gunakan huruf kecil 'alumni' jika itu standar di database Anda
            $stmt2 = $db->prepare("UPDATE users SET role = 'alumni' WHERE id IN ($placeholders)");
            $stmt2->execute($ids);

            $db->commit();
            header('Location: /admin/members?status=updated');
        } catch (\Exception $e) {
            if (isset($db)) $db->rollBack();
            die("Gagal update massal: " . $e->getMessage());
        }
    }
}
