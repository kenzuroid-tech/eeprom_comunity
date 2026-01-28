<?php
// Inisialisasi data tetap sama seperti sebelumnya
$adminData = $adminData ?? [];
$totalAnggota = $totalAnggota ?? 0;
$totalKegiatan = $totalKegiatan ?? 0;
$totalAnnouncements = $totalAnnouncements ?? 0;
$totalVotes = $totalVotes ?? 0;
$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($adminData['nama_lengkap'] ?? 'Admin') . '&background=1A237E&color=fff';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
</head>

<body>
    <div class="dashboard-container">
        <?php include __DIR__ . '/includes/sidebar.php'; ?>

        <main class="main-content">
            <?php include __DIR__ . '/includes/header.php'; ?>

            <div class="row g-4 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="stat-card card-active">
                        <div class="stat-body">
                            <h2 class="fw-bold m-0"><?= $totalAnggota ?></h2>
                            <p class="m-0 small text-uppercase fw-bold opacity-75">Anggota</p>
                        </div>
                        <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-people"></i></div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card card-activity">
                        <div class="stat-body">
                            <h2 class="fw-bold m-0"><?= $totalKegiatan ?></h2>
                            <p class="m-0 small text-uppercase fw-bold opacity-75">Kegiatan</p>
                        </div>
                        <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-calendar-event"></i></div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card card-msg">
                        <div class="stat-body">
                            <h2 class="fw-bold m-0"><?= $totalAnnouncements ?></h2>
                            <p class="m-0 small text-uppercase fw-bold opacity-75">Pesan</p>
                        </div>
                        <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-megaphone"></i></div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card card-vote">
                        <div class="stat-body">
                            <h2 class="fw-bold m-0"><?= $totalVotes ?></h2>
                            <p class="m-0 small text-uppercase fw-bold opacity-75">Votes</p>
                        </div>
                        <div class="stat-icon bg-danger-subtle text-danger"><i class="bi bi-patch-check"></i></div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="content-card">
                        <h5 class="fw-bold mb-4"><i class="bi bi-graph-up-arrow me-2"></i>Statistik Kehadiran</h5>
                        <div style="height: 350px;">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="content-card">
                        <h5 class="fw-bold mb-4"><i class="bi bi-clock-history me-2"></i>Log Aktivitas</h5>
                        <div class="log-list">
                            <?php if (!empty($logs)): foreach ($logs as $log): ?>
                                    <div class="log-item">
                                        <div class="log-indicator bg-<?= $log['color'] ?>"></div>
                                        <div class="log-text">
                                            <p class="m-0 fw-bold small text-dark"><?= htmlspecialchars($log['msg']) ?></p>
                                            <small class="text-muted"><?= date('d M, H:i', strtotime($log['created_at'])) ?></small>
                                        </div>
                                    </div>
                                <?php endforeach;
                            else: ?>
                                <p class="text-center text-muted py-5 small">Belum ada aktivitas.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>