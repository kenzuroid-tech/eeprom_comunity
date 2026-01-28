<?php
/**
 * Logic Pendeteksi URL Otomatis
 */
$current_uri = $_SERVER['REQUEST_URI'];
$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : '/assets/images/default-avatar.png';

// Inisialisasi default
$header_title = "Dashboard";
$header_subtitle = "Selamat datang kembali di panel kendali EEPROM.";

// Cek URL untuk menentukan teks header
if (strpos($current_uri, '/admin/members') !== false) {
    $header_title = "Manajemen Anggota";
    $header_subtitle = "Kelola data seluruh personil EEPROM Polinema.";
} elseif (strpos($current_uri, '/admin/members/create') !== false) {
    $header_title = "Tambah Anggota Baru";
    $header_subtitle = "Kelola data seluruh personil EEPROM Polinema.";
} elseif (strpos($current_uri, '/admin/divisions') !== false) {
    $header_title = "Divisi Manajemen";
    $header_subtitle = "Kelola data seluruh personil EEPROM Polinema.";
} elseif (strpos($current_uri, '/admin/about') !== false) {
    $header_title = "About Management";
    $header_subtitle = "Perbarui informasi profil dan sejarah organisasi.";
} elseif (strpos($current_uri, '/admin/forum') !== false) {
    $header_title = "Moderasi Forum";
    $header_subtitle = "Pantau dan kelola diskusi antar anggota komunitas.";
} elseif (strpos($current_uri, '/admin/meetings') !== false) {
    $header_title = "Meetings & Attendance";
    $header_subtitle = "Jadwalkan rapat dan pantau kehadiran anggota.";
} elseif (strpos($current_uri, '/admin/documents') !== false) {
    $header_title = "Document Management";
    $header_subtitle = "Pusat penyimpanan file, LPJ, dan proposal resmi.";
} elseif (strpos($current_uri, '/admin/achievement') !== false) {
    $header_title = "Achievement Management";
    $header_subtitle = "Dokumentasikan prestasi dan penghargaan yang diraih.";
} elseif (strpos($current_uri, '/admin/contacts') !== false) {
    $header_title = "Contact Management";
    $header_subtitle = "Kelola pesan masuk dan informasi kontak organisasi.";
} elseif (strpos($current_uri, '/admin/products') !== false) {
    $header_title = "Robot Marketplace";
    $header_subtitle = "Kelola katalog produk inovasi robotika EEPROM.";
}
?>

<header class="top-nav shadow-sm mb-4 bg-white rounded-4 px-4 py-3 d-flex justify-content-between align-items-center">
    <div class="nav-left d-flex align-items-center">
        <button class="btn btn-outline-primary border-0 me-3 d-lg-none" onclick="toggleSidebar()">
            <i class="bi bi-list fs-3"></i>
        </button>
        
        <div class="nav-title">
            <h4 class="fw-bold m-0 text-dark"><?= $header_title ?></h4>
            <p class="text-muted m-0 small d-none d-md-block"><?= $header_subtitle ?></p>
        </div>
    </div>

    <div class="dropdown">
        <div class="user-profile d-flex align-items-center dropdown-toggle cursor-pointer" id="userMenu" data-bs-toggle="dropdown" style="cursor: pointer;">
            <div class="user-info d-none d-sm-block text-end me-3">
                <span class="d-block fw-bold small text-dark"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Admin') ?></span>
                <span class="badge bg-primary-subtle text-primary" style="font-size: 9px;">ADMINISTRATOR</span>
            </div>
            <img src="<?= htmlspecialchars($adminFotoNavbar) ?>" 
                 alt="Profile" 
                 class="rounded-circle border" 
                 width="40" height="40" 
                 style="object-fit: cover; border: 2px solid var(--primary-blue) !important; padding: 2px;">
        </div>
        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 rounded-4 p-2">
            <li><a class="dropdown-item rounded-3 py-2" href="/member/profile"><i class="bi bi-person me-2 text-primary"></i>Profil Saya</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger rounded-3 py-2" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
        </ul>
    </div>
</header>