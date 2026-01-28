<?php

namespace App\Controllers;

use App\Helpers\DatabaseHelper;

class ContactController {
    public function index() {
        $db = DatabaseHelper::getConnection();

        // Ambil info kontak organisasi dari database
        $contactInfo = $db->query("SELECT * FROM organization_contact LIMIT 1")->fetch(\PDO::FETCH_ASSOC);
        
        // Ambil daftar Contact Person
        $cpList = $db->query("SELECT * FROM contact_persons ORDER BY sort_order ASC")->fetchAll(\PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/contact/index.php';
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = DatabaseHelper::getConnection();
            
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';

            try {
                $stmt = $db->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $email, $subject, $message]);
                
                header("Location: /contact?status=success");
            } catch (\Exception $e) {
                header("Location: /contact?status=error");
            }
            exit;
        }
    }
}