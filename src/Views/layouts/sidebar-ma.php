<nav id="sidebarMenu" class="sidebar">
    <div class="sidebar-header">
        <img src="/assets/images/eeprom_logo.png" alt="logo" width="45" class="mb-2">
        <h3>Member Area</h3>
    </div>

    <div class="sidebar-nav">
        <?php
        // Mengambil path URL saja (tanpa query string)
        $current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        ?>

        <a href="/member/dashboard" class="nav-link <?php echo ($current_page == '/member/dashboard') ? 'active' : ''; ?>">
            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
        </a>

        <a href="/member/profile" class="nav-link <?php echo (strpos($current_page, '/member/profile') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-person-circle"></i><span>My Profile</span>
        </a>

        <a href="/member/gallery" class="nav-link <?php echo (strpos($current_page, '/member/gallery') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-images"></i><span>Gallery</span>
        </a>

        <a href="/member/attendance" class="nav-link <?php echo (strpos($current_page, '/member/attendance') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-calendar-check"></i><span>Presensi</span>
        </a>

        <a href="/member/announcements" class="nav-link <?php echo (strpos($current_page, '/member/announcements') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-megaphone"></i><span>Pengumuman</span>
        </a>

        <a href="/member/forum" class="nav-link <?php echo (strpos($current_page, '/member/forum') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-chat-dots"></i><span>Forum Diskusi</span>
        </a>

        <a href="/member/voting" class="nav-link <?php echo (strpos($current_page, '/member/voting') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-patch-check"></i><span>Voting</span>
        </a>


        <a href="/member/documents" class="nav-link <?php echo (strpos($current_page, '/member/documents') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-file-earmark-text"></i><span>Documents</span>
        </a>

        <hr class="mx-3 my-2" style="border-top: 1px solid rgba(255,255,255,0.1)">

        <a href="/logout" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
    </div>

    <div class="sidebar-footer">
        © <?php echo date("Y"); ?> EEPROM POLINEMA
    </div>
</nav>