<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard - EEPROM POLINEMA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/member-area/dashboard.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include __DIR__ . '/../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-none d-md-block">
                        <h5 class="m-0 fw-bold text-dark">Selamat Datang, <?= htmlspecialchars($dashboardData['nama']) ?>! 👋</h5>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <a href="#" class="text-dark position-relative" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2" style="width: 250px;">
                            <li><h6 class="dropdown-header">Notifikasi Terbaru</h6></li>
                            <li><a class="dropdown-item small rounded" href="#">Rapat Divisi Software besok!</a></li>
                            <li><a class="dropdown-item small rounded" href="#">Voting Ketua Umum dibuka.</a></li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="<?= htmlspecialchars($dashboardData['foto']) ?>" alt="Profile" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover;">
                            <span class="d-none d-sm-inline text-dark fw-bold small"><?= htmlspecialchars($dashboardData['nama']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="/member/profile"><i class="bi bi-person me-2"></i>Profile Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="row g-4 mb-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded">
                        <p class="small text-muted mb-1">Kehadiran</p>
                        <h3 class="fw-bold m-0" style="color: #0d6efd;"><?= $dashboardData['attendance'] ?>%</h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded">
                        <p class="small text-muted mb-1">Total Rapat</p>
                        <h3 class="fw-bold m-0" style="color: #0d6efd;"><?= $dashboardData['total_meetings'] ?></h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded">
                        <p class="small text-muted mb-1">Status Voting</p>
                        <span class="badge bg-warning text-dark"><?= htmlspecialchars($dashboardData['voting_status']) ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded">
                        <p class="small text-muted mb-1">Active Since</p>
                        <h6 class="fw-bold m-0" style="color: #0d6efd;"><?= htmlspecialchars($dashboardData['active_since']) ?></h6>
                    </div>
                </div>
            </div>

            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/member-area/dashboard.js"></script>
</body>
</html>