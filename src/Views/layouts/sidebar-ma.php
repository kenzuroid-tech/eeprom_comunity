<nav id="sidebarMenu" class="sidebar">
    <div class="sidebar-header">
        <img src="/public/assets/images/eeprom logo.png" alt="logo" width="45" class="mb-2">
        <h3>Member Area</h3>
    </div>

    <div class="sidebar-nav">
        <?php $current_page = $_SERVER['REQUEST_URI']; ?>
        
        <a href="/src/Views/member-area/dashboard.php" class="nav-link <?php echo (strpos($current_page, 'dashboard.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-speedometer2"></i><span>Dashboard</span>
        </a>

        <a href="/src/Views/member-area/profile/index.php" class="nav-link <?php echo (strpos($current_page, 'profile/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-person-circle"></i><span>My Profile</span>
        </a>

        <a href="/src/Views/member-area/gallery/index.php" class="nav-link <?php echo (strpos($current_page, 'gallery/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-images"></i><span>Gallery</span>
        </a>

        <a href="/src/Views/member-area/attendance/index.php" class="nav-link <?php echo (strpos($current_page, 'attendance/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-calendar-check"></i><span>Presensi</span>
        </a>

        <a href="/src/Views/member-area/announcements/index.php" class="nav-link <?php echo (strpos($current_page, 'announcements/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-megaphone"></i><span>Pengumuman</span>
        </a>

        <a href="/src/Views/member-area/voting/index.php" class="nav-link <?php echo (strpos($current_page, 'voting/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-patch-check"></i><span>Voting</span>
        </a>

        <a href="/src/Views/member-area/forum/index.php" class="nav-link <?php echo (strpos($current_page, 'forum/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-chat-dots"></i><span>Forum</span>
        </a>

        <a href="/src/Views/member-area/documents/index.php" class="nav-link <?php echo (strpos($current_page, 'documents/index.php') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-file-earmark-text"></i><span>Documents</span>
        </a>

        <hr class="mx-3 my-2" style="border-top: 1px solid rgba(255,255,255,0.1)">

        <a href="/src/Views/public/auth/login.php" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
    </div>

    <div class="sidebar-footer">
        © <?php echo date("Y"); ?> EEPROM POLINEMA
    </div>
</nav>