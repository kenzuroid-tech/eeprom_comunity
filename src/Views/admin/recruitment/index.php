<?php

/**
 * File: src/Views/admin/recruitment/index.php
 */
$adminData = $adminData ?? [];
$stats = $stats ?? ['total' => 0, 'pending' => 0, 'accepted' => 0, 'rejected' => 0];
$activePeriod = $activePeriod ?? null;
$recentApplicants = $recentApplicants ?? [];
$allPeriods = $allPeriods ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin/recruitment/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold text-primary">Recruitment Management</h4>
                </div>
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-bold small"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Admin') ?></span>
                    <img src="<?= $adminData['foto_url'] ?? 'https://ui-avatars.com/api/?name=Admin' ?>" width="35" height="35" class="rounded-circle border">
                </div>
            </nav>

            <div class="row g-4 mb-4">
                <div class="col-lg-12">
                    <div class="widget-card-admin bg-white p-4 rounded shadow-sm border-0">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0 text-dark">
                                <i class="bi bi-lightning-charge-fill text-warning me-2"></i>Active Recruitment Dashboard
                            </h5>
                            <?php if ($activePeriod): ?>
                                <span class="badge bg-success-subtle text-success border border-success px-3 rounded-pill">
                                    <?= htmlspecialchars($activePeriod['nama_periode']) ?>
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Tidak Ada Periode Aktif</span>
                            <?php endif; ?>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="countdown-box h-100 d-flex flex-column justify-content-center p-3 rounded-4 bg-primary text-white text-center">
                                    <p class="small mb-1 opacity-75">Sisa Waktu Pendaftaran</p>
                                    <h2 class="fw-bold mb-0" id="countdown" data-deadline="<?= $activePeriod['tanggal_selesai'] ?? '' ?>">
                                        -- : -- : --
                                    </h2>
                                    <p class="small mt-1 opacity-75">Hari : Jam : Menit</p>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="row g-2 h-100">
                                    <div class="col-6">
                                        <div class="stat-mini-box h-100 d-flex flex-column justify-content-center p-3 border rounded-4 bg-light text-center">
                                            <p class="text-muted small mb-1">Total Aplikasi</p>
                                            <h3 class="fw-bold mb-0 text-primary"><?= $stats['total'] ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-6 text-start">
                                        <div class="p-3 border rounded-4 bg-white h-100 shadow-sm">
                                            <div class="d-flex justify-content-between small mb-2">
                                                <span><i class="bi bi-clock-history text-warning me-1"></i>Pending</span>
                                                <span class="fw-bold"><?= $stats['pending'] ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between small mb-2">
                                                <span><i class="bi bi-check-circle-fill text-success me-1"></i>Accepted</span>
                                                <span class="fw-bold"><?= $stats['accepted'] ?></span>
                                            </div>
                                            <div class="d-flex justify-content-between small">
                                                <span><i class="bi bi-x-circle-fill text-danger me-1"></i>Rejected</span>
                                                <span class="fw-bold"><?= $stats['rejected'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h6 class="fw-bold small mb-3 text-muted text-uppercase">Recent Applicants</h6>
                                <div class="list-group list-group-flush shadow-sm rounded-4 border overflow-hidden">
                                    <?php if (empty($recentApplicants)): ?>
                                        <div class="list-group-item small text-center py-3 text-muted">Belum ada pendaftar.</div>
                                        <?php else: foreach ($recentApplicants as $recent): ?>
                                            <div class="list-group-item bg-white px-3 py-2 d-flex align-items-center border-0 border-bottom">
                                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($recent['nama_lengkap']) ?>&background=random" class="rounded-circle me-3" width="32" height="32">
                                                <div class="flex-grow-1">
                                                    <p class="small mb-0 fw-bold text-dark"><?= htmlspecialchars($recent['nama_lengkap']) ?></p>
                                                    <p class="mb-0 text-muted" style="font-size: 10px;"><?= date('H:i', strtotime($recent['created_at'])) ?> WIB</p>
                                                </div>
                                                <span class="badge bg-light text-primary border rounded-pill" style="font-size: 9px;">Baru</span>
                                            </div>
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-4 mt-5 text-dark">Daftar Periode Recruitment</h5>
            <div class="row g-4">
                <?php if (empty($allPeriods)): ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-clipboard-x display-1 text-muted"></i>
                        <p class="mt-3 text-muted">Belum ada data periode rekrutmen.</p>
                    </div>
                    <?php else: foreach ($allPeriods as $p): ?>
                        <div class="col-md-4">
                            <div class="recruitment-card p-4 bg-white rounded shadow-sm border-0 position-relative overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge rounded-pill px-3 py-2 <?= $p['status'] == 'Active' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $p['status'] ?>
                                    </span>
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                            <li>
                                                <a class="dropdown-item" href="/admin/recruitment/edit?id=<?= $p['id'] ?>">
                                                    <i class="bi bi-pencil-square me-2 text-primary"></i> Edit Periode
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a href="/admin/recruitment/delete?id=<?= $p['id'] ?>"
                                                    class="dropdown-item text-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus periode ini? Semua data pelamar juga akan hilang.')">
                                                    <i class="bi bi-trash me-2"></i> Hapus Periode
                                                </a>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($p['nama_periode']) ?></h5>
                                <p class="text-muted small mb-4"><i class="bi bi-calendar3 me-2 text-primary"></i><?= date('d M', strtotime($p['tanggal_mulai'])) ?> - <?= date('d M Y', strtotime($p['tanggal_selesai'])) ?></p>

                                <div class="row g-2 mb-4">
                                    <div class="col-4">
                                        <div class="p-2 border rounded-3 text-center bg-light">
                                            <h6 class="fw-bold mb-0"><?= $p['total'] ?></h6>
                                            <p class="m-0 text-muted" style="font-size: 9px;">TOTAL</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded-3 text-center bg-light">
                                            <h6 class="fw-bold mb-0 text-warning"><?= $p['pending'] ?></h6>
                                            <p class="m-0 text-muted" style="font-size: 9px;">PENDING</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 border rounded-3 text-center bg-light">
                                            <h6 class="fw-bold mb-0 text-success"><?= $p['accepted'] ?></h6>
                                            <p class="m-0 text-muted" style="font-size: 9px;">ACCEPTED</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="/admin/recruitment/applicants?id=<?= $p['id'] ?>" class="btn btn-primary w-100 rounded-pill fw-bold btn-sm py-2">
                                    View Applicants <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Logika Countdown Real-time
        function startCountdown() {
            const el = document.getElementById('countdown');
            const deadlineAttr = el.getAttribute('data-deadline');

            if (!deadlineAttr) {
                el.innerText = "00 : 00 : 00";
                return;
            }

            const deadline = new Date(deadlineAttr).getTime();

            const timer = setInterval(() => {
                const now = new Date().getTime();
                const gap = deadline - now;

                if (gap <= 0) {
                    clearInterval(timer);
                    el.innerText = "CLOSED";
                    return;
                }

                const d = Math.floor(gap / (1000 * 60 * 60 * 24));
                const h = Math.floor((gap % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((gap % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((gap % (1000 * 60)) / 1000);

                el.innerText = `${d.toString().padStart(2, '0')} : ${h.toString().padStart(2, '0')} : ${m.toString().padStart(2, '0')}`;
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', startCountdown);

        // Toggle Sidebar Mobile
        document.getElementById('mobile-toggle')?.addEventListener('click', () => {
            document.querySelector('.dashboard-wrapper')?.classList.toggle('sidebar-collapsed');
        });
    </script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>