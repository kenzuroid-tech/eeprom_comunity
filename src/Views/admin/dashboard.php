<?php
$adminData = $adminData ?? [];
// Tambahkan inisialisasi default agar tidak error jika variabel belum dikirim
$totalAnggota = $totalAnggota ?? 0;
$totalKegiatan = $totalKegiatan ?? 0;
$totalAnnouncements = $totalAnnouncements ?? 0;
$totalVotes = $totalVotes ?? 0;
$fotoPath = $fotoPath ?? '/assets/images/default_profile.png';
$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($adminData['nama_lengkap'] ?? 'Admin');

$chartLabels = json_encode(array_column($chartData ?? [], 'title'));
$chartValues = json_encode(array_column($chartData ?? [], 'hadir'));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">

            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <h4 class="m-0 fw-bold">Admin Dashboard</h4>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        id="adminDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>"
                            alt="Profile"
                            width="35"
                            height="35"
                            class="rounded-circle me-2"
                            style="object-fit: cover; border: 1px solid #ddd;">
                        <span class="d-none d-sm-inline text-dark fw-bold">
                            <?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="adminDropdown">
                        <li>
                            <a class="dropdown-item py-2" href="/member/profile">
                                <i class="bi bi-person me-2 text-primary"></i>Profile
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
            </nav>

            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="stat-card-admin shadow-sm bg-white p-3 rounded" style="border-left: 5px solid #28a745;">
                        <i class="bi bi-people stat-icon fs-1" style="color: #28a745;"></i>
                        <div>
                            <h3 class="m-0 fw-bold"><?= $totalAnggota ?></h3>
                            <p class="small m-0 text-muted">Anggota</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin shadow-sm bg-white p-3 rounded" style="border-left: 5px solid #0d6efd;">
                        <i class="bi bi-calendar-event stat-icon fs-1 text-primary"></i>
                        <div>
                            <h3 class="m-0 fw-bold"><?= $totalKegiatan ?></h3>
                            <p class="small m-0 text-muted">Kegiatan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin shadow-sm bg-white p-3 rounded" style="border-left: 5px solid #ffc107;">
                        <i class="bi bi-megaphone stat-icon fs-1" style="color: #ffc107;"></i>
                        <div>
                            <h3 class="m-0 fw-bold"><?= $totalAnnouncements ?></h3>
                            <p class="small m-0 text-muted">Pengumuman</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin shadow-sm bg-white p-3 rounded" style="border-left: 5px solid #f44336;">
                        <i class="bi bi-box2-heart stat-icon fs-1" style="color: #f44336;"></i>
                        <div>
                            <h3 class="m-0 fw-bold"><?= $totalVotes ?></h3>
                            <p class="small m-0 text-muted">Total Suara</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="widget-card-admin bg-white p-4 rounded shadow-sm h-100">
                        <h5 class="mb-4 fw-bold text-dark">Statistik Kehadiran Anggota (Hadir)</h5>
                        <canvas id="attendanceChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="widget-card-admin bg-white p-4 rounded shadow-sm h-100">
                        <h5 class="mb-4 fw-bold text-dark">Sistem Log Terbaru</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3 small pb-2 border-bottom text-muted">
                                <i class="bi bi-circle-fill text-success me-2" style="font-size: 8px;"></i>
                                Database terhubung dengan lancar.
                            </li>
                            <li class="mb-3 small pb-2 border-bottom text-muted">
                                <i class="bi bi-circle-fill text-primary me-2" style="font-size: 8px;"></i>
                                Sesi login Admin (ID 3) divalidasi.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>