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
            <nav class="top-navbar d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light border me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-none d-md-block">
                        <h5 class="m-0 fw-bold text-dark">Halo, <?= htmlspecialchars($dashboardData['nama']) ?>! 👋</h5>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">

                    <div class="dropdown">
                        <a href="#" class="btn btn-light btn-sm rounded-circle position-relative p-2" data-bs-toggle="dropdown">
                            <i class="bi bi-bell text-dark"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.6rem;">
                                3
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 mt-3" style="width: 260px;">
                            <li>
                                <h6 class="dropdown-header fw-bold">Pesan Terbaru</h6>
                            </li>
                            <li><a class="dropdown-item small rounded py-2" href="#">📌 Rapat Divisi Software besok!</a></li>
                            <li><a class="dropdown-item small rounded py-2" href="#">🗳️ Voting Ketua Umum dibuka.</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-center small text-primary" href="#">Lihat Semua</a></li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle p-1 rounded-pill" data-bs-toggle="dropdown">
                            <img src="<?= htmlspecialchars($dashboardData['foto']) ?>"
                                alt="Profile"
                                width="35"
                                height="35"
                                class="rounded-circle border"
                                style="object-fit: cover;">
                            <span class="d-none d-sm-inline text-dark fw-bold small ms-2">
                                <?= htmlspecialchars($dashboardData['nama']) ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                            <!-- <li>
                                <a class="dropdown-item py-2" href="/member/profile">
                                    <i class="bi bi-person me-2 text-primary"></i>Profile Saya
                                </a>
                            </li> -->
                            <li>
                                <a class="dropdown-item py-2" href="/member/settings">
                                    <i class="bi bi-gear me-2 text-secondary"></i>Pengaturan
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger py-2" href="/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="row g-4 mb-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-primary border-4">
                        <p class="small text-muted mb-1"><i class="bi bi-person-check me-1"></i>Kehadiran</p>
                        <h3 class="fw-bold m-0 text-primary"><?= $dashboardData['attendance'] ?>%</h3>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-info border-4">
                        <p class="small text-muted mb-1"><i class="bi bi-calendar-event me-1"></i>Total Rapat</p>
                        <h3 class="fw-bold m-0 text-info"><?= $dashboardData['total_meetings'] ?></h3>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-warning border-4">
                        <p class="small text-muted mb-1"><i class="bi bi-envelope-paper me-1"></i>Status Voting</p>
                        <?php if ($dashboardData['voting_status'] === 'Sudah Memilih'): ?>
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Sudah Memilih</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle me-1"></i>Belum Memilih</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-secondary border-4">
                        <p class="small text-muted mb-1"><i class="bi bi-clock-history me-1"></i>Active Since</p>
                        <h6 class="fw-bold m-0 text-dark"><?= htmlspecialchars($dashboardData['active_since']) ?></h6>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/member-area/dashboard.js"></script>
</body>

</html>