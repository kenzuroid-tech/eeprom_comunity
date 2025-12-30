<?php 
// Mendapatkan URL saat ini
$current_page = $_SERVER['REQUEST_URI']; 
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/src/Views/home/index.php#hero">
            <img src="/public/assets/images/eeprom logo.png" alt="Logo EEPROM" class="me-2" style="width: 40px;">
            <h1 class="m-0 fs-4 fw-bold text-primary">EEPROM POLINEMA</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($current_page, 'home/index.php') !== false || $current_page == '/') ? 'active' : ''; ?>" 
                       href="/src/Views/public/home/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($current_page, 'activity/index.php') !== false) ? 'active' : ''; ?>" 
                       href="/src/Views/activity/index.php">Activity</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($current_page, 'member/index.php') !== false) ? 'active' : ''; ?>" 
                       href="/src/Views/member/index.php">Members</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($current_page, 'contact/index.php') !== false) ? 'active' : ''; ?>" 
                       href="/src/Views/contact/index.php">Contact</a>
                </li>
            </ul>
            <div class="d-flex align-items-center ms-lg-4">
                <a href="/src/Views/public/auth/login.php" class="text-secondary text-decoration-none">
                    <i class="bi bi-person-circle fs-3"></i>
                </a>
            </div>
        </div>
    </div>
</nav>