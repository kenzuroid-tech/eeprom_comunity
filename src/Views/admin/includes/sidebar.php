<nav id="sidebarMenu" class="sidebar">
    <div class="sidebar-header">
        <img src="/assets/images/eeprom_logo.png" alt="Logo" width="45" class="mb-2">
        <h3>EEPROM Admin</h3>
    </div>

    <div class="sidebar-nav">
        <?php
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
            <i class="bi bi-people-fill"></i><span>Manajemen Anggota</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('member', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/admin/members" class="nav-link <?php echo ($current_page == '/admin/members') ? 'active' : ''; ?>">
                <i class="bi bi-person-lines-fill"></i>Daftar Anggota
            </a>
            <a href="/admin/members/create" class="nav-link <?php echo ($current_page == '/admin/members/create') ? 'active' : ''; ?>">
                <i class="bi bi-person-plus-fill"></i>Tambah Anggota
            </a>
            <a href="/admin/divisions" class="nav-link <?php echo ($current_page == '/admin/divisions') ? 'active' : ''; ?>">
                <i class="bi bi-diagram-3-fill"></i>Struktur Divisi
            </a>
        </div>

        <a href="/admin/about" class="nav-link <?php echo ($current_page == '/admin/about') ? 'active' : ''; ?>">
            <i class="bi bi-info-circle-fill"></i><span>About Organization</span>
        </a>

        <a href="/admin/achievement" class="nav-link <?php echo ($current_page == '/admin/achievement') ? 'active' : ''; ?>">
            <i class="bi bi-trophy-fill"></i><span>Achievements</span>
        </a>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/admin/activities') !== false) {
                                                                        echo 'active';
                                                                        $active_dropdowns[] = 'activities';
                                                                    } ?>">
            <i class="bi bi-calendar-check-fill"></i><span>Aktivitas</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('activities', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/admin/activities" class="nav-link <?php echo ($current_page == '/admin/activities') ? 'active' : ''; ?>">
                <i class="bi bi-list-stars"></i>Daftar Aktivitas
            </a>
            <a href="/admin/activities/create" class="nav-link <?php echo ($current_page == '/admin/activities/create') ? 'active' : ''; ?>">
                <i class="bi bi-plus-circle-dotted"></i>Tambah Aktivitas
            </a>
        </div>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/admin/recruitment') !== false) {
                                                                        echo 'active';
                                                                        $active_dropdowns[] = 'recruitment';
                                                                    } ?>">
            <i class="bi bi-person-badge-fill"></i><span>Recruitment</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('recruitment', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/admin/recruitment" class="nav-link <?php echo ($current_page == '/admin/recruitment') ? 'active' : ''; ?>">
                <i class="bi bi-pie-chart-fill"></i>Status Seleksi
            </a>
            <a href="/admin/recruitment/applicants" class="nav-link <?php echo ($current_page == '/admin/recruitment/applicants') ? 'active' : ''; ?>">
                <i class="bi bi-file-earmark-person-fill"></i>Daftar Pelamar
            </a>
            <a href="/admin/recruitment/create" class="nav-link <?php echo ($current_page == '/admin/recruitment/create') ? 'active' : ''; ?>">
                <i class="bi bi-megaphone-fill"></i>Buka Pendaftaran
            </a>
        </div>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/admin/meetings') !== false) {
                                                                        echo 'active';
                                                                        $active_dropdowns[] = 'meetings';
                                                                    } ?>">
            <i class="bi bi-camera-video-fill"></i><span>Meetings</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('meetings', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/admin/meetings/" class="nav-link <?php echo ($current_page == '/admin/meetings/') ? 'active' : ''; ?>">
                <i class="bi bi-clock-history"></i>Riwayat Rapat
            </a>
            <a href="/admin/meetings/notulensi" class="nav-link <?php echo ($current_page == '/admin/meetings/notulensi') ? 'active' : ''; ?>">
                <i class="bi bi-journal-text"></i>Notulen Rapat
            </a>
        </div>

        <a href="/admin/announcements" class="nav-link <?php echo (strpos($current_page, '/admin/announcements') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-broadcast-pin"></i><span>Pengumuman</span>
        </a>

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/admin/voting') !== false) {
                                                                        echo 'active';
                                                                        $active_dropdowns[] = 'election';
                                                                    } ?>">
            <i class="bi bi-box-seam-fill"></i><span>Pemilihan (Election)</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div class="nav-dropdown-items <?php echo in_array('election', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/admin/voting/create" class="nav-link <?php echo ($current_page == '/admin/voting/create') ? 'active' : ''; ?>">
                <i class="bi bi-patch-plus-fill"></i>Buat Sesi Baru
            </a>
            <a href="/admin/voting" class="nav-link <?php echo ($current_page == '/admin/voting') ? 'active' : ''; ?>">
                <i class="bi bi-toggle-on"></i>Sesi Aktif
            </a>
            <a href="/admin/voting/candidates" class="nav-link <?php echo ($current_page == '/admin/voting/candidates') ? 'active' : ''; ?>">
                <i class="bi bi-person-bounding-box"></i>Kelola Kandidat
            </a>
            <a href="/admin/voting/results" class="nav-link <?php echo ($current_page == '/admin/voting/results') ? 'active' : ''; ?>">
                <i class="bi bi-bar-chart-line-fill"></i>Hasil Pemilihan
            </a>
        </div>

        <a href="/admin/documents" class="nav-link <?php echo (strpos($current_page, '/admin/documents') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-file-earmark-zip-fill"></i><span>Arsip Dokumen</span>
        </a>

        <a href="/admin/gallery" class="nav-link <?php echo (strpos($current_page, '/admin/gallery') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-images"></i><span>Galeri Foto</span>
        </a>

        <a href="/admin/forum" class="nav-link <?php echo (strpos($current_page, '/admin/forum') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-chat-left-dots-fill"></i><span>Forum Diskusi</span>
        </a>

        <a href="/admin/contacts" class="nav-link <?php echo (strpos($current_page, '/admin/contacts') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-envelope-paper-fill"></i><span>Pesan Masuk</span>
        </a>

        <hr class="mx-3 opacity-10">

        <a href="/admin/settings" class="nav-link <?php echo ($current_page == '/admin/settings') ? 'active' : ''; ?>">
            <i class="bi bi-gear-fill"></i><span>Settings</span>
        </a>

        <a href="/logout" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i><span>Keluar</span>
        </a>
    </div>

    <div class="sidebar-footer">
        © <?php echo date("Y"); ?> EEPROM POLINEMA
    </div>
</nav>