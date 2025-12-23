<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EEPROM POLINEMA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    
    <link rel="stylesheet" href="/public/assets/css/admin/dashboard.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include 'includes/sidebar.php'; ?>
        
        <div id="mainContentWrapper" class="main-content-area">
            <?php include 'includes/header.php'; ?>

            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="stat-card-admin" style="border-left-color: #28a745;">
                        <i class="bi bi-people stat-icon" style="color: #28a745;"></i>
                        <div><h3 class="m-0">250</h3><p class="small m-0">Anggota</p></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin">
                        <i class="bi bi-calendar-event stat-icon"></i>
                        <div><h3 class="m-0">12</h3><p class="small m-0">Kegiatan</p></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin" style="border-left-color: #ffc107;">
                        <i class="bi bi-envelope-paper stat-icon" style="color: #ffc107;"></i>
                        <div><h3 class="m-0">5</h3><p class="small m-0">Lamaran Baru</p></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin" style="border-left-color: #f44336;">
                        <i class="bi bi-trophy stat-icon" style="color: #f44336;"></i>
                        <div><h3 class="m-0">17</h3><p class="small m-0">Prestasi</p></div>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin">
                <h5 class="mb-4 fw-bold"><i class="bi bi-check2-all me-2 text-primary"></i>Status Tugas Divisi</h5>
                <div class="row g-3">
                    <div class="col-6 col-lg-3">
                        <div class="division-card text-center">
                            <i class="bi bi-gear-wide-connected fs-2 mb-2 text-secondary"></i>
                            <h6 class="mb-2">Mekanik</h6>
                            <span class="status-badge status-selesai">Selesai</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="division-card text-center">
                            <i class="bi bi-code-slash fs-2 mb-2 text-primary"></i>
                            <h6 class="mb-2">Software</h6>
                            <span class="status-badge status-belum">Belum Selesai</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="division-card text-center">
                            <i class="bi bi-cpu fs-2 mb-2 text-warning"></i>
                            <h6 class="mb-2">Elektrik</h6>
                            <span class="status-badge status-selesai">Selesai</span>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="division-card text-center">
                            <i class="bi bi-megaphone fs-2 mb-2 text-danger"></i>
                            <h6 class="mb-2">Humas</h6>
                            <span class="status-badge status-telat">Segera Lapor</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="widget-card-admin">
                        <h5 class="mb-4 fw-bold">Statistik Kehadiran Anggota</h5>
                        <div class="chart-placeholder">
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="widget-card-admin">
                        <h5 class="mb-4 fw-bold">Recent Logs</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3 small pb-2 border-bottom">
                                <i class="bi bi-circle-fill text-success me-2" style="font-size: 8px;"></i>
                                Admin A merubah status rekrutmen.
                            </li>
                            <li class="mb-3 small pb-2 border-bottom">
                                <i class="bi bi-circle-fill text-primary me-2" style="font-size: 8px;"></i>
                                Update info komunitas dilakukan.
                            </li>
                            <li class="small">
                                <i class="bi bi-circle-fill text-warning me-2" style="font-size: 8px;"></i>
                                Sesi voting baru dimulai.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/dashboard.js"></script>
</body>
</html>