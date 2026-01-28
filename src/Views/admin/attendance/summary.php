<?php

/**
 * File: src/Views/admin/attendance/summary.php
 */
$adminData = $adminData ?? [];
$summaries = $summaries ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <style>
        .card-stat {
            transition: transform 0.2s;
            border: none;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }

        .bg-orange {
            background-color: #ff6b00;
        }

        .text-orange {
            color: #ff6b00;
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center p-3 shadow-sm bg-white">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold text-dark">Rekapitulasi Absensi</h4>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?= $adminData['foto_url'] ?? 'https://ui-avatars.com/api/?name=Admin' ?>" alt="Profile" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover;">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="p-4">
                <div class="mb-4">
                    <h2 class="fw-bold">Daftar Kehadiran Rapat</h2>
                    <p class="text-muted">Pantau tingkat partisipasi anggota anggota EEPROM di setiap agenda rapat.</p>
                </div>

                <?php if (empty($summaries)): ?>
                    <div class="alert alert-info border-0 shadow-sm p-4 text-center">
                        <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                        <h5>Belum ada data rapat.</h5>
                        <p class="mb-0">Silakan buat rapat baru terlebih dahulu di menu Meetings.</p>
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($summaries as $row): ?>
                            <div class="col-md-6 col-xl-4">
                                <div class="card card-stat shadow-sm h-100">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2">
                                                ID #MTG-<?= $row['id'] ?>
                                            </span>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                <?= date('d M Y', strtotime($row['date'])) ?>
                                            </small>
                                        </div>

                                        <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($row['title']) ?></h5>
                                        <p class="small text-muted mb-4 text-truncate">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                            <?= htmlspecialchars($row['location']) ?>
                                        </p>

                                        <div class="row g-2 text-center">
                                            <div class="col-4">
                                                <div class="p-2 bg-success-subtle rounded-3 border border-success-subtle">
                                                    <h4 class="mb-0 fw-bold text-success"><?= $row['total_hadir'] ?></h4>
                                                    <div class="text-success fw-medium" style="font-size: 0.65rem; letter-spacing: 0.5px;">HADIR</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-2 bg-warning-subtle rounded-3 border border-warning-subtle">
                                                    <h4 class="mb-0 fw-bold text-warning"><?= $row['total_izin'] ?></h4>
                                                    <div class="text-warning fw-medium" style="font-size: 0.65rem; letter-spacing: 0.5px;">IZIN</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="p-2 bg-danger-subtle rounded-3 border border-danger-subtle">
                                                    <h4 class="mb-0 fw-bold text-danger"><?= $row['total_alpa'] ?></h4>
                                                    <div class="text-danger fw-medium" style="font-size: 0.65rem; letter-spacing: 0.5px;">ALPA</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-light border-0 p-3">
                                        <div class="d-grid">
                                            <a href="/admin/attendance/input?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm rounded-2 fw-semibold">
                                                <i class="bi bi-pencil-square me-2"></i>Kelola Absensi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar for Mobile
        const mobileToggle = document.getElementById('mobile-toggle');
        const sidebar = document.querySelector('.sidebar-wrapper'); // Pastikan selector sesuai dengan sidebar.php Anda
        if (mobileToggle) {
            mobileToggle.addEventListener('click', () => {
                document.querySelector('.dashboard-wrapper').classList.toggle('sidebar-open');
            });
        }
    </script>
    <script src="/assets/js/admin/dashboard.js"></script>

</body>

</html>