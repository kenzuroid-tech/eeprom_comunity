<?php
namespace Controllers\Member;

class HomeController {
    public function index() {
        // Logika untuk mengambil data dari model jika diperlukan
        // Misalnya: $announcements = AnnouncementModel::getLatest();
        
        // Include view
        include __DIR__ . '/../../Views/member-area/home.php';
    }
}
?>