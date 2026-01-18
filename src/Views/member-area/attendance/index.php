<?php
$userData = $userData ?? [];
$stats = $stats ?? ['total_pertemuan' => 0, 'total_hadir' => 0, 'total_alpa' => 0];
$attendanceRecords = $attendanceRecords ?? [];

// Kalkulasi Persentase
$persentase = ($stats['total_pertemuan'] > 0) ? round(($stats['total_hadir'] / $stats['total_pertemuan']) * 100) : 0;
$fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($userData['nama_lengkap'] ?? 'User');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/member-area/attendance/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light border me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h5 class="m-0 fw-bold text-dark">Presensiku</h5>
                    </div>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle p-1 rounded-pill hover-bg-light" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($fotoPath) ?>"
                            alt="Profile"
                            width="35"
                            height="35"
                            class="rounded-circle border"
                            style="object-fit: cover;">
                        <span class="d-none d-sm-inline text-dark fw-bold small ms-2 me-1">
                            <?= htmlspecialchars($userData['nama_lengkap'] ?? 'Member') ?>
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                        <div class="px-3 py-2 d-sm-none border-bottom mb-2">
                            <p class="m-0 fw-bold small text-truncate" style="max-width: 150px;">
                                <?= htmlspecialchars($userData['nama_lengkap'] ?? 'Member') ?>
                            </p>
                        </div>

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
            </nav>

            <div class="row g-4 mb-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-4 border-primary">
                        <p class="small text-muted mb-1">Total Pertemuan</p>
                        <h3 class="fw-bold"><?= $stats['total_pertemuan'] ?></h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-4 border-success">
                        <p class="small text-muted mb-1">Total Hadir</p>
                        <h3 class="fw-bold text-success"><?= $stats['total_hadir'] ?></h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-4 border-danger">
                        <p class="small text-muted mb-1">Tidak Hadir</p>
                        <h3 class="fw-bold text-danger"><?= $stats['total_alpa'] ?></h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-4 border-warning">
                        <p class="small text-muted mb-1">Persentase</p>
                        <h3 class="fw-bold text-warning"><?= $persentase ?>%</h3>
                    </div>
                </div>
            </div>

            <div class="widget-card-member bg-white p-4 rounded shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Judul Pertemuan</th>
                                <th>Tanggal & Waktu</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($attendanceRecords)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat kehadiran.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1;
                                foreach ($attendanceRecords as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($row['title']) ?></td>
                                        <td>
                                            <?= date('d M Y', strtotime($row['date'])) ?>,
                                            <?= substr($row['start_time'], 0, 5) ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['location']) ?></td>
                                        <td>
                                            <?php
                                            $badgeClass = 'bg-secondary';
                                            if ($row['status'] == 'Hadir') $badgeClass = 'bg-success';
                                            elseif ($row['status'] == 'Izin') $badgeClass = 'bg-warning text-dark';
                                            elseif ($row['status'] == 'Tidak Hadir') $badgeClass = 'bg-danger';
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= $row['status'] ?></span>
                                        </td>
                                        <td class="text-muted small"><?= htmlspecialchars($row['remarks'] ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <footer class="mt-5 text-center py-3 border-top small text-muted">
                © <?= date("Y") ?> EEPROM POLINEMA - Developed by Nisho
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>