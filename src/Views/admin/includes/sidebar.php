<?php
$current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<style>
    :root {
        --sidebar-width: 280px;
        /* Mengubah ke Primary Blue sesuai identitas EEPROM */
        --sidebar-bg: #1A237E;
        --sidebar-color: rgba(255, 255, 255, 0.7);
        --primary-blue: #1A237E;
        --accent-orange: #FF5722;
        --hover-bg: rgba(255, 255, 255, 0.1);
        --active-bg: #FF5722;
        /* Kontras oranye untuk menu aktif */
        --shadow-sidebar: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* Floating Sidebar Styling - Dark Theme */
    #sidebarMenu {
        width: var(--sidebar-width);
        height: calc(100vh - 40px);
        position: fixed;
        top: 20px;
        left: 5px;
        background: var(--sidebar-bg);
        border-radius: 24px;
        box-shadow: var(--shadow-sidebar);
        z-index: 1050;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
    }

    .sidebar-header {
        padding: 30px 25px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-header img {
        filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.2));
    }

    .sidebar-header h3 {
        font-size: 1.1rem;
        font-weight: 800;
        color: #ffffff;
        margin: 10px 0 0;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: 20px 15px;
    }

    /* Scrollbar Styling untuk Dark Theme */
    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 18px;
        color: var(--sidebar-color) !important;
        text-decoration: none !important;
        border-radius: 14px;
        margin-bottom: 6px;
        transition: all 0.3s;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .nav-link i:first-child {
        font-size: 1.2rem;
        margin-right: 12px;
        width: 25px;
        text-align: center;
        transition: 0.3s;
    }

    .nav-link:hover {
        background: var(--hover-bg);
        color: #ffffff !important;
        transform: translateX(5px);
    }

    .nav-link.active {
        background: var(--active-bg);
        color: #ffffff !important;
        box-shadow: 0 8px 15px rgba(255, 87, 34, 0.4);
    }

    .nav-link.active i {
        color: #ffffff;
    }

    /* Dropdown Styling */
    .nav-dropdown-items {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
        padding-left: 10px;
        background: rgba(0, 0, 0, 0.15);
        border-radius: 14px;
        margin: 0 5px 10px;
    }

    .nav-dropdown-items.show {
        max-height: 600px;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .dropdown-btn .bi-chevron-down {
        transition: transform 0.3s;
        font-size: 0.8rem;
    }

    .dropdown-btn.active .bi-chevron-down {
        transform: rotate(180deg);
    }

    .sidebar-footer {
        padding: 20px;
        font-size: 0.7rem;
        text-align: center;
        color: rgba(255, 255, 255, 0.4);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(0, 0, 0, 0.1);
    }

    /* Mobile Logic */
    @media (max-width: 991.98px) {
        #sidebarMenu {
            left: -320px;
            top: 10px;
            height: calc(100vh - 20px);
        }

        #sidebarMenu.show {
            left: 10px;
            width: calc(100% - 20px);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(13, 17, 54, 0.8);
            backdrop-filter: blur(6px);
            z-index: 1040;
        }

        .sidebar-overlay.show {
            display: block;
        }
    }

    /* Content Adjustment */
    .admin-main-content {
        margin-left: calc(var(--sidebar-width) + 40px);
        padding: 30px;
        transition: all 0.4s;
    }

    @media (max-width: 991.98px) {
        .admin-main-content {
            margin-left: 0;
        }
    }
</style>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

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

        <a href="/admin" class="nav-link <?php echo ($current_page == '/admin/dashboard') ? 'active' : ''; ?>">
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

        <a href="javascript:void(0)" class="nav-link dropdown-btn <?php if (strpos($current_page, '/admin/products') !== false || strpos($current_page, '/admin/orders') !== false) {
                                                                        echo 'active';
                                                                        $active_dropdowns[] = 'marketplace';
                                                                    } ?>" onclick="toggleDropdown(this, 'dropdownMarketplace')">
            <i class="bi bi-shop"></i><span>Marketplace</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>
        <div id="dropdownMarketplace" class="nav-dropdown-items <?php echo in_array('marketplace', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/admin/products" class="nav-link <?php echo ($current_page == '/admin/products') ? 'active' : ''; ?>">
                <i class="bi bi-robot"></i>Kelola Produk
            </a>
            <a href="/admin/orders" class="nav-link <?php echo (strpos($current_page, '/admin/orders') !== false) ? 'active' : ''; ?>">
                <i class="bi bi-cart-check-fill"></i>Pesanan Masuk
            </a>
        </div>

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
                                                                    } ?>" onclick="toggleDropdown(this, 'dropdownVoting')">
            <i class="bi bi-box-seam-fill"></i><span>Pemilihan (Election)</span>
            <i class="bi bi-chevron-down ms-auto small"></i>
        </a>

        <div id="dropdownVoting" class="nav-dropdown-items <?php echo in_array('election', $active_dropdowns) ? 'show' : ''; ?>">
            <a href="/admin/voting" class="nav-link <?php echo ($current_page == '/admin/voting') ? 'active' : ''; ?>">
                <i class="bi bi-bar-chart-line-fill"></i>Dashboard Voting
            </a>

            <a href="/admin/voting/candidates" class="nav-link <?php echo ($current_page == '/admin/voting/candidates') ? 'active' : ''; ?>">
                <i class="bi bi-people-fill"></i>Kandidat
            </a>

            <a href="/admin/voting/access-codes" class="nav-link <?php echo ($current_page == '/admin/voting/access-codes') ? 'active' : ''; ?>">
                <i class="bi bi-key-fill"></i>Kode Akses
            </a>

            <a href="/admin/voting/results" class="nav-link <?php echo ($current_page == '/admin/voting/results') ? 'active' : ''; ?>">
                <i class="bi bi-trophy-fill"></i>Hasil Pemilihan
            </a>

            <a href="/admin/voting/create" class="nav-link <?php echo ($current_page == '/admin/voting/create') ? 'active' : ''; ?>">
                <i class="bi bi-patch-plus-fill"></i>Buat Sesi Baru
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

        <?php if ($_SESSION['role'] === 'superadmin'): ?>
            <li class="nav-item">
                <a href="/admin/settings" class="nav-link">
                    <i class="bi bi-gear"></i> System Settings
                </a>
            </li>
        <?php endif; ?>

        <a href="/logout" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i><span>Keluar</span>
        </a>
    </div>

    <div class="sidebar-footer">
        © <?php echo date("Y"); ?> EEPROM POLINEMA
    </div>
</nav>

<script>
    function toggleDropdown(btn, id) {
        // Menghentikan bubbling agar tidak memicu fungsi lain secara tidak sengaja
        event.stopPropagation();

        const dropdown = document.getElementById(id);
        const isShowing = dropdown.classList.contains('show');

        // Opsional: Tutup semua dropdown lain sebelum membuka yang baru (Accordion mode)
        document.querySelectorAll('.nav-dropdown-items').forEach(d => {
            d.classList.remove('show');
        });
        document.querySelectorAll('.dropdown-btn').forEach(b => {
            b.classList.remove('active');
        });

        // Jika sebelumnya tidak terbuka, maka buka sekarang
        if (!isShowing) {
            dropdown.classList.add('show');
            btn.classList.add('active');
        }
    }

    // Fungsi toggle sidebar untuk mobile - Pastikan ID sesuai
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebarMenu');
        const overlay = document.getElementById('sidebarOverlay');

        if (sidebar && overlay) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    }

    // Menutup sidebar jika overlay diklik (Hanya di Mobile)
    const overlayElement = document.getElementById('sidebarOverlay');
    if (overlayElement) {
        overlayElement.onclick = toggleSidebar;
    }
</script>