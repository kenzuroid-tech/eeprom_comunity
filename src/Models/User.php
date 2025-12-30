<?php

namespace App\Models;

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByIdentifier($identifier)
    {
        $stmt = $this->pdo->prepare("
            SELECT u.*, m.nama_lengkap, m.nim, m.divisi 
            FROM users u
            LEFT JOIN members m ON u.id = m.user_id
            WHERE (u.username = :identifier OR u.email = :identifier) 
            AND u.is_active = TRUE
        ");
        $stmt->execute(['identifier' => $identifier]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function updateLastLogin($userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }
}