<?php

namespace App\Controllers\Member;

use App\Helpers\DatabaseHelper; // Pastikan helper database di-import

class DashboardController 
{
    public function index() 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Bypass sementara jika login belum stabil (seperti di ProfileController)
        if (!isset($_SESSION['id'])) {
            $_SESSION['id'] = 2; 
        }

        try {
            $db = DatabaseHelper::getConnection();

            // Ambil data nama lengkap dan foto dari tabel members
            $stmt = $db->prepare("
                SELECT u.role, m.nama_lengkap, m.foto_url 
                FROM users u 
                LEFT JOIN members m ON u.id = m.user_id 
                WHERE u.id = :id
            ");
            $stmt->execute(['id' => $_SESSION['id']]);
            $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Siapkan data untuk dikirim ke view
            $dashboardData = [
                'nama' => $userData['nama_lengkap'] ?? 'Anggota',
                'role' => $userData['role'] ?? 'Member',
                'foto' => $userData['foto_url'] ?? '/assets/images/memeng.jpg',
                'attendance' => 0, // Nanti diisi dengan query asli
                'total_meetings' => 0,
                'voting_status' => 'Belum Voting',
                'active_since' => '2025'
            ];

            // Load view dashboard dengan membawa variabel $dashboardData
            require_once __DIR__ . '/../../Views/member-area/dashboard.php';

        } catch (\PDOException $e) {
            die("Kesalahan Database: " . $e->getMessage());
        }
    }
}