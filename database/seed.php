<?php
require_once __DIR__ . '/../src/Helpers/DatabaseHelper.php';
use App\Helpers\DatabaseHelper;

try {
    $db = DatabaseHelper::getConnection();
    echo "🌱 Starting seeding process...\n";

    $db->exec("TRUNCATE TABLE users, members RESTART IDENTITY CASCADE");
    echo "✅ Existing data cleared.\n";

    $users = [
        [
            'username' => 'superadmin',
            'email'    => 'super@eeprom.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role'     => 'superadmin',
            'nama'     => 'Master Super Admin'
        ],
        [
            'username' => 'admin',
            'email'    => 'admin@eeprom.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role'     => 'admin',
            'nama'     => 'Admin Pengurus'
        ],
        [
            'username' => '244107020014',
            'email'    => 'anggota@eeprom.com',
            'password' => password_hash('bismillah', PASSWORD_DEFAULT),
            'role'     => 'anggota',
            'nama'     => 'Anggota EEPROM'
        ]
    ];

    foreach ($users as $u) {
        // Insert ke tabel users
        $stmtUser = $db->prepare("
            INSERT INTO users (username, email, password, role, is_active) 
            VALUES (:username, :email, :password, :role, TRUE) 
            RETURNING id
        ");
        
        $stmtUser->execute([
            'username' => $u['username'],
            'email'    => $u['email'],
            'password' => $u['password'],
            'role'     => $u['role']
        ]);
        
        $userId = $stmtUser->fetchColumn();

        // Insert ke tabel members agar profil muncul di dashboard
        $stmtMember = $db->prepare("
            INSERT INTO members (user_id, nama_lengkap, nim, email, status_keanggotaan, jabatan) 
            VALUES (:user_id, :nama, :nim, :email, 'Active', :jabatan)
        ");

        $stmtMember->execute([
            'user_id' => $userId,
            'nama'    => $u['nama'],
            'nim'     => $u['username'], // Anggota pake NIM, admin pake username
            'email'   => $u['email'],
            'jabatan' => ucfirst($u['role'])
        ]);

        echo "✅ Created User: {$u['username']} ({$u['role']})\n";
    }

    echo "\n🚀 Seeding finished successfully!\n";

} catch (Exception $e) {
    echo "❌ Seeding Error: " . $e->getMessage() . "\n";
    exit(1);
}