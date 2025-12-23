<nav class="top-navbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
            <i class="bi bi-list"></i>
        </button>
        <?php
        $current_page = $_SERVER['REQUEST_URI'];
        $page_titles = [
            '/admin/dashboard.php' => 'Overview Dashboard',
            '/src/Views/admin/members/index.php' => 'Daftar Anggota',
            '/src/Views/admin/divisions/index.php' => 'Division Management',
            '/src/Views/admin/recruitment/index.php' => 'Recruitment',
            '/src/Views/admin/about/index.php' => 'Info Komunitas',
            '/src/Views/admin/activities/index.php' => 'Aktivitas',
            '/src/Views/admin/achievements/index.php' => 'Penghargaan',
            '/src/Views/admin/meetings/index.php' => 'Jadwal Rapat',
            '/src/Views/admin/attendance/index.php' => 'Presensi',
            '/src/Views/admin/announcements/index.php' => 'List Pengumuman',
            '/src/Views/admin/announcements/create.php' => 'Tambah Pengumuman',
            '/src/Views/admin/gallery/index.php' => 'Gallery',
            '/src/Views/admin/voting/candidates.php' => 'Kandidat',
            '/src/Views/admin/voting/index.php' => 'Sesi Voting',
            '/src/Views/admin/voting/results.php' => 'Hasil Pemilihan',
            '/src/Views/admin/contacts/index.php' => 'Contacts',
            '/src/Views/admin/settings/index.php' => 'Settings',
        ];
        $title = 'Dashboard'; // Default
        foreach ($page_titles as $path => $page_title) {
            if (strpos($current_page, $path) !== false) {
                $title = $page_title;
                break;
            }
        }
        ?>
        <h4 class="m-0"><?php echo $title; ?></h4>
    </div>
    
    <div class="d-flex align-items-center">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name=Admin+EEPROM&background=1A237E&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
                <span class="d-none d-sm-inline text-dark fw-bold">Super Admin</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>