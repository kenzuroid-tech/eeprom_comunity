<nav id="sidebarMenu" class="sidebar">
    <div class="sidebar-header">
        <img src="/public/assets/images/eeprom logo.png" alt="Logo" width="45" class="mb-2">
        <h3>EEPROM Admin</h3>
    </div>

    <div class="sidebar-nav">
        <?php
        $current_page = $_SERVER['REQUEST_URI'];
        $active_dropdowns = [];
        ?>

        <a href="/src/Views/admin/dashboard.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/dashboard.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
        </a>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/src/Views/admin/members/') !== false || strpos($current_page, '/src/Views/admin/divisions/') !== false || strpos($current_page, '/src/Views/admin/recruitment/') !== false) { echo 'active'; $active_dropdowns[] = 'member'; } ?>">
            <i class="bi bi-people-fill"></i><span>Member</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('member', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/src/Views/admin/members/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/members/index.php') !== false) ? 'active' : ''; ?>">Daftar Anggota</a>
            <a href="/src/Views/admin/divisions/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/divisions/index.php') !== false) ? 'active' : ''; ?>">Divisi</a>
            <a href="/src/Views/admin/recruitment/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/recruitment/index.php') !== false) ? 'active' : ''; ?>">Recruitment</a>
        </div>

        <a href="/src/Views/admin/about/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/about/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-info-square-fill"></i><span>Info Komunitas</span>
        </a>

        <a href="/src/Views/admin/activities/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/activities/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-activity"></i><span>Aktivitas</span>
        </a>

        <a href="/src/Views/admin/achievements/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/achievements/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-trophy-fill"></i><span>Penghargaan</span>
        </a>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/src/Views/admin/meetings/') !== false || strpos($current_page, '/src/Views/admin/attendance/') !== false) { echo 'active'; $active_dropdowns[] = 'meetings'; } ?>">
            <i class="bi bi-calendar-check-fill"></i><span>Rapat dan Pertemuan</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('meetings', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/src/Views/admin/meetings/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/meetings/index.php') !== false) ? 'active' : ''; ?>">Jadwal Rapat</a>
            <a href="/src/Views/admin/attendance/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/attendance/index.php') !== false) ? 'active' : ''; ?>">Presensi</a>
        </div>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/src/Views/admin/announcements/') !== false) { echo 'active'; $active_dropdowns[] = 'announcements'; } ?>">
            <i class="bi bi-megaphone-fill"></i><span>Pengumuman</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('announcements', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/src/Views/admin/announcements/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/announcements/index.php') !== false) ? 'active' : ''; ?>">List Pengumuman</a>
            <a href="/src/Views/admin/announcements/create.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/announcements/create.php') !== false) ? 'active' : ''; ?>">Tambah Pengumuman</a>
        </div>

        <a href="/src/Views/admin/gallery/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/gallery/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-images"></i><span>Gallery</span>
        </a>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/src/Views/admin/voting/') !== false) { echo 'active'; $active_dropdowns[] = 'election'; } ?>">
            <i class="bi bi-patch-check-fill"></i><span>Election</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('election', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/src/Views/admin/voting/candidates.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/voting/candidates.php') !== false) ? 'active' : ''; ?>">Kandidat</a>
            <a href="/src/Views/admin/voting/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/voting/index.php') !== false) ? 'active' : ''; ?>">Sesi Voting</a>
            <a href="/src/Views/admin/voting/results.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/voting/results.php') !== false) ? 'active' : ''; ?>">Hasil Pemilihan</a>
        </div>

        <a href="/src/Views/admin/contacts/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/contacts/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-person-lines-fill"></i><span>Contacts</span>
        </a>

        <hr class="mx-3 opacity-10">

        <a href="/src/Views/admin/settings/index.php" class="nav-link <?php echo (strpos($current_page, '/src/Views/admin/settings/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-gear-fill"></i><span>Settings</span>
        </a>

        <a href="/logout.php" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
    </div>

    <div class="sidebar-footer">
        © <?php echo date("Y"); ?> EEPROM POLINEMA
    </div>
</nav>