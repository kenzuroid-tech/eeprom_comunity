<?php
$userData = $userData ?? [];
$stats = $stats ?? ['total_pertemuan' => 0, 'total_hadir' => 0, 'total_alpa' => 0];
$attendanceRecords = $attendanceRecords ?? [];

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

    <style>
        /* Optimasi Mobile */
        @media (max-width: 768px) {
            .main-content-area {
                padding: 15px !important;
            }

            .stat-card-member h3 {
                font-size: 1.25rem;
            }

            /* Sembunyikan Header Tabel di HP */
            .table-responsive thead {
                display: none;
            }

            /* Ubah baris tabel menjadi tampilan Card */
            .table-responsive tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #eee;
                border-radius: 10px;
                padding: 10px;
                background: #fdfdfd;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
            }

            .table-responsive tbody td {
                display: block;
                text-align: right;
                font-size: 0.9rem;
                border-bottom: 1px solid #f5f5f5;
                padding: 8px 5px;
            }

            .table-responsive tbody td::before {
                content: attr(data-label);
                float: left;
                font-weight: 700;
                color: #666;
            }

            .table-responsive tbody td:last-child {
                border-bottom: none;
            }

            /* Penyesuaian khusus teks */
            .mobile-bold {
                font-weight: bold;
                color: #333;
            }
        }

        .stat-card-member {
            transition: transform 0.2s;
        }

        .stat-card-member:hover {
            transform: translateY(-3px);
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center bg-white p-2 p-md-3 rounded shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light border me-2 me-md-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h5 class="m-0 fw-bold text-dark">Presensiku</h5>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle p-1 rounded-pill hover-bg-light" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($fotoPath) ?>" width="32" height="32" class="rounded-circle border" style="object-fit: cover;">
                        <span class="d-none d-sm-inline text-dark fw-bold small ms-2 me-1">
                            <?= htmlspecialchars($userData['nama_lengkap'] ?? 'Member') ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                        <li><a class="dropdown-item py-2" href="/member/settings"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="row g-2 g-md-4 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-4 border-primary h-100">
                        <p class="small text-muted mb-1">Total Rapat</p>
                        <h3 class="fw-bold mb-0"><?= $stats['total_pertemuan'] ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-4 border-success h-100">
                        <p class="small text-muted mb-1">Hadir</p>
                        <h3 class="fw-bold text-success mb-0"><?= $stats['total_hadir'] ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-4 border-danger h-100">
                        <p class="small text-muted mb-1">Alpa</p>
                        <h3 class="fw-bold text-danger mb-0"><?= $stats['total_alpa'] ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card-member shadow-sm p-3 bg-white rounded border-start border-4 border-warning h-100">
                        <p class="small text-muted mb-1">Persentase</p>
                        <h3 class="fw-bold text-warning mb-0"><?= $persentase ?>%</h3>
                    </div>
                </div>
            </div>

            <div class="widget-card-member bg-white p-3 p-md-4 rounded shadow-sm">
                <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Kehadiran</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Pertemuan</th>
                                <th>Waktu</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($attendanceRecords)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-calendar-x d-block mb-2 fs-2"></i> Belum ada riwayat.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1;
                                foreach ($attendanceRecords as $row): ?>
                                    <tr>
                                        <td data-label="No"><?= $no++ ?></td>
                                        <td data-label="Pertemuan" class="mobile-bold text-primary"><?= htmlspecialchars($row['title']) ?></td>
                                        <td data-label="Waktu">
                                            <span class="d-block"><?= date('d M Y', strtotime($row['date'])) ?></span>
                                            <small class="text-muted"><?= substr($row['start_time'], 0, 5) ?></small>
                                        </td>
                                        <td data-label="Lokasi"><?= htmlspecialchars($row['location']) ?></td>
                                        <td data-label="Status">
                                            <?php
                                            $badgeClass = match ($row['status']) {
                                                'Hadir' => 'bg-success',
                                                'Izin' => 'bg-warning text-dark',
                                                'Tidak Hadir' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                            ?>
                                            <span class="badge <?= $badgeClass ?> px-3"><?= $row['status'] ?></span>
                                        </td>
                                        <td data-label="Catatan" class="small italic text-muted"><?= htmlspecialchars($row['remarks'] ?? '-') ?></td>
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
    <script src="/assets/js/member-area/dashboard.js"></script>
</body>

</html>