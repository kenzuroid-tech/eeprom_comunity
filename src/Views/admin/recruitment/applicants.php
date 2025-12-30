<?php

/**
 * File: src/Views/admin/recruitment/applicants.php
 */
$adminData = $adminData ?? [];
$period = $period ?? ['nama_periode' => 'Tidak Diketahui'];
$applicants = $applicants ?? [];

// Hitung statistik real-time dari data hasil filter
$countTotal = count($applicants);
$countPending = 0;
$countInterview = 0;
$countAccepted = 0;
$countRejected = 0;

foreach ($applicants as $a) {
    if ($a['status'] == 'Pending') $countPending++;
    if ($a['status'] == 'Interview') $countInterview++;
    if ($a['status'] == 'Accepted') $countAccepted++;
    if ($a['status'] == 'Rejected') $countRejected++;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelamar - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin/recruitment/applicant.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <a href="/admin/recruitment" class="btn btn-outline-secondary btn-sm me-3 rounded-circle">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h4 class="m-0 fw-bold">Daftar Pelamar</h4>
                        <small class="text-muted">Periode: <?= htmlspecialchars($period['nama_periode']) ?></small>
                    </div>
                </div>
                <button class="btn btn-success shadow-sm px-3 fw-bold">
                    <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                </button>
            </nav>

            <div class="row g-3 mb-4">
                <?php
                $statItems = [
                    ['Total', $countTotal, '#0d6efd'],
                    ['Pending', $countPending, '#f9a825'],
                    ['Interview', $countInterview, '#1976d2'],
                    ['Accepted', $countAccepted, '#2e7d32'],
                    ['Rejected', $countRejected, '#c62828']
                ];
                foreach ($statItems as $stat):
                ?>
                    <div class="col-md col-6">
                        <div class="stat-card-mini bg-white p-3 rounded shadow-sm border-bottom border-4" style="border-bottom-color: <?= $stat[2] ?>;">
                            <p class="small text-muted mb-1 text-uppercase fw-bold"><?= $stat[0] ?></p>
                            <h3 class="m-0 fw-bold"><?= $stat[1] ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                <form action="/admin/recruitment/applicants" method="GET" class="row g-3 align-items-end">
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?? '' ?>">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold">Cari Pelamar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Nama atau NIM..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold">Filter Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Pending" <?= ($_GET['status'] ?? '') == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Interview" <?= ($_GET['status'] ?? '') == 'Interview' ? 'selected' : '' ?>>Interview</option>
                            <option value="Accepted" <?= ($_GET['status'] ?? '') == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                            <option value="Rejected" <?= ($_GET['status'] ?? '') == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Filter</button>
                        <a href="/admin/recruitment/applicants?id=<?= $_GET['id'] ?? '' ?>" class="btn btn-light w-100 fw-bold border text-decoration-none text-center">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bulk-action-bar bg-dark text-white p-3 rounded shadow mb-4" id="bulkBar" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-check-circle-fill text-success me-2"></i> <span id="selectedCount" class="fw-bold">0</span> Pelamar Terpilih</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-light px-3">Interview</button>
                        <button class="btn btn-sm btn-success px-3">Accept</button>
                        <button class="btn btn-sm btn-danger px-3">Reject</button>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin bg-white rounded shadow-sm overflow-hidden border-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                <th width="50">No</th>
                                <th>Nama Pelamar</th>
                                <th>NIM</th>
                                <th>Prodi</th>
                                <th>Divisi</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($applicants)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">Belum ada pelamar di periode ini.</td>
                                </tr>
                                <?php else: $no = 1;
                                foreach ($applicants as $app): ?>
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input row-checkbox" value="<?= $app['id'] ?>"></td>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($app['nama_lengkap']) ?>&background=random" class="rounded-circle me-3" width="35" height="35">
                                                <div>
                                                    <div class="fw-bold"><?= htmlspecialchars($app['nama_lengkap']) ?></div>
                                                    <small class="text-muted"><?= htmlspecialchars($app['email'] ?? '') ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($app['nim']) ?></td>
                                        <td><?= htmlspecialchars($app['prodi'] ?? '-') ?></td>
                                        <td><span class="badge bg-primary-subtle text-primary border-0"><?= htmlspecialchars($app['divisi_pilihan_1'] ?? '-') ?></span></td>
                                        <td>
                                            <?php
                                            $badgeCls = match ($app['status']) {
                                                'Accepted' => 'bg-success',
                                                'Rejected' => 'bg-danger',
                                                'Interview' => 'bg-info',
                                                default => 'bg-warning text-dark'
                                            };
                                            ?>
                                            <span class="badge <?= $badgeCls ?> px-3"><?= $app['status'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm">
                                                <a href="/admin/recruitment/applicant/detail?id=<?= $app['id'] ?>" class="btn btn-sm btn-white border text-primary" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a> <button class="btn btn-sm btn-white border dropdown-toggle" data-bs-toggle="dropdown"></button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                    <li><button class="dropdown-item text-info"><i class="bi bi-chat-dots me-2"></i>Interview</button></li>
                                                    <li><button class="dropdown-item text-success"><i class="bi bi-check-circle me-2"></i>Accept</button></li>
                                                    <li><button class="dropdown-item text-danger"><i class="bi bi-x-circle me-2"></i>Reject</button></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const bulkBar = document.getElementById('bulkBar');
        const selectedCount = document.getElementById('selectedCount');

        function updateBulkBar() {
            const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
            bulkBar.style.display = checkedCount > 0 ? 'block' : 'none';
            selectedCount.textContent = checkedCount;
        }

        if (selectAll) {
            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkBar();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkBar);
        });
    </script>
</body>

</html>