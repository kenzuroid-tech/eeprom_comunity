<nav id="sidebarMenu" class="sidebar">
    <div class="sidebar-header">
        <img src="/assets/images/eeprom_logo.png" alt="Logo" width="45" class="mb-2">
        <h3>EEPROM Admin</h3>
    </div>

    <div class="sidebar-nav">
        <?php
        // Mengambil path URL saja (tanpa query string) untuk deteksi menu aktif
        $current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $active_dropdowns = [];
        ?>

        <a href="/admin/dashboard" class="nav-link <?php echo ($current_page == '/admin/dashboard') ? 'active' : ''; ?>">
            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
        </a>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/admin/members') !== false || strpos($current_page, '/admin/divisions') !== false) {
                                                                        echo 'active';
                                                                        $active_dropdowns[] = 'member';
                                                                    } ?>">
            <i class="bi bi-people-fill"></i><span>Member</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('member', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/admin/members" class="nav-link <?php echo ($current_page == '/admin/members') ? 'active' : ''; ?>">Daftar Anggota</a>
            <a href="/admin/members/create" class="nav-link <?php echo ($current_page == '/admin/members/create') ? 'active' : ''; ?>">Tambah Anggota</a>
            <a href="/admin/divisions" class="nav-link <?php echo ($current_page == '/admin/divisions') ? 'active' : ''; ?>">Divisi</a>
        </div>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/admin/recruitment') !== false) {
                                                                        echo 'active';
                                                                        $active_dropdowns[] = 'recruitment';
                                                                    } ?>">
            <i class="bi bi-person-plus-fill"></i><span>Recruitment</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('recruitment', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/admin/recruitment" class="nav-link <?php echo ($current_page == '/admin/recruitment') ? 'active' : ''; ?>">Dashboard</a>
            <a href="/admin/recruitment/applicants" class="nav-link <?php echo ($current_page == '/admin/recruitment/applicants') ? 'active' : ''; ?>">Daftar Pelamar</a>
            <a href="/admin/recruitment/create" class="nav-link <?php echo ($current_page == '/admin/recruitment/create') ? 'active' : ''; ?>">Buka Pendaftaran</a>
            <a href="/admin/recruitment/edit" class="nav-link <?php echo ($current_page == '/admin/recruitment/edit') ? 'active' : ''; ?>">Edit Pendaftaran</a>

        </div>

        <a href="/admin/meetings" class="nav-link <?php echo (strpos($current_page, '/admin/meetings') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-calendar-check-fill"></i><span>Rapat & Pertemuan</span>
        </a>

        <a href="/admin/attendance" class="nav-link <?php echo (strpos($current_page, '/admin/attendance') !== false) ? 'active' : ''; ?>">
            <i class="bi-person-check"></i><span>Absensi</span>
        </a>

        <a href="/admin/announcements" class="nav-link <?php echo (strpos($current_page, '/admin/announcements') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-megaphone-fill"></i><span>Pengumuman</span>
        </a>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/admin/voting') !== false) {
                                                                        echo 'active';
                                                                        $active_dropdowns[] = 'election';
                                                                    } ?>">
            <i class="bi bi-patch-check-fill"></i><span>Election</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('election', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/admin/voting" class="nav-link <?php echo ($current_page == '/admin/voting') ? 'active' : ''; ?>">Sesi Voting</a>
            <a href="/admin/voting/candidates" class="nav-link <?php echo ($current_page == '/admin/voting/candidates') ? 'active' : ''; ?>">Kandidat</a>
            <a href="/admin/voting/results" class="nav-link <?php echo ($current_page == '/admin/voting/results') ? 'active' : ''; ?>">Hasil Pemilihan</a>
        </div>

        <a href="/admin/documents" class="nav-link <?php echo (strpos($current_page, '/admin/documents') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-file-earmark-text-fill"></i><span>Documents</span>
        </a>

        <a href="/admin/gallery" class="nav-link <?php echo (strpos($current_page, '/admin/gallery') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-images"></i><span>Gallery</span>
        </a>

        <hr class="mx-3 opacity-10">

        <a href="/logout" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
    </div>

    <div class="sidebar-footer">
        © <?php echo date("Y"); ?> EEPROM POLINEMA
    </div>
</nav>