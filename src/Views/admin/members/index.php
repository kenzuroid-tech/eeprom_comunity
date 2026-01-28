<?php

/**
 * File: src/Views/admin/members/index.php
 */
$adminData = $adminData ?? [];
$allMembers = $allMembers ?? [];
$totalAnggota = count($allMembers);

$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($adminData['nama_lengkap'] ?? 'Admin') . '&background=1A237E&color=fff';

$current_status = $_GET['status'] ?? 'all';
$searchVal = $_GET['search'] ?? '';
$divisiVal = $_GET['filter_divisi'] ?? '';
$generasiVal = $_GET['filter_generasi'] ?? '';

function buildTabUrl($status, $search, $divisi, $generasi)
{
    return "?status=$status&search=" . urlencode($search) . "&filter_divisi=" . urlencode($divisi) . "&filter_generasi=" . urlencode($generasi);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/members/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <main id="mainContentWrapper" class="admin-main-content">
            <?php include_once __DIR__ . '/../includes/header.php'; ?>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> Status anggota berhasil diperbarui menjadi Alumni.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-md-4 col-lg-3">
                    <div class="stat-mini-card shadow-sm">
                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h3 class="m-0 fw-bold"><?= $totalAnggota ?></h3>
                            <p class="small m-0 text-muted fw-bold text-uppercase">Personil Terfilter</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card shadow-sm p-3 p-md-4">
                <ul class="nav nav-tabs-custom mb-4 overflow-x-auto flex-nowrap">
                    <li class="nav-item">
                        <a class="nav-link <?= $current_status == 'all' ? 'active' : '' ?>" href="<?= buildTabUrl('all', $searchVal, $divisiVal, $generasiVal) ?>">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strtolower($current_status) == 'active' ? 'active' : '' ?>" href="<?= buildTabUrl('Active', $searchVal, $divisiVal, $generasiVal) ?>">Aktif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strtolower($current_status) == 'alumni' ? 'active' : '' ?>" href="<?= buildTabUrl('Alumni', $searchVal, $divisiVal, $generasiVal) ?>">Alumni</a>
                    </li>
                </ul>

                <form action="" method="GET" class="mb-4 p-3 bg-light rounded-4 border border-light-subtle">
                    <input type="hidden" name="status" value="<?= htmlspecialchars($current_status) ?>">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-bold">Pencarian</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama atau NIM..." value="<?= htmlspecialchars($searchVal) ?>">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small fw-bold">Divisi</label>
                            <select class="form-select shadow-sm" name="filter_divisi">
                                <option value="">Semua Divisi</option>
                                <?php foreach (['Software', 'Mekanik', 'Elektrik', 'Humas'] as $d): ?>
                                    <option value="<?= $d ?>" <?= $divisiVal == $d ? 'selected' : '' ?>><?= $d ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <label class="form-label small fw-bold">Generasi</label>
                            <select class="form-select shadow-sm" name="filter_generasi">
                                <option value="">Semua</option>
                                <?php for ($i = 1; $i <= 20; $i++): ?>
                                    <option value="<?= $i ?>" <?= $generasiVal == $i ? 'selected' : '' ?>>Gen <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mt-3 mt-md-0">
                            <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm">
                                <i class="bi bi-funnel-fill me-1"></i> Terapkan Filter
                            </button>
                        </div>
                    </div>
                </form>

                <form id="bulkActionForm" method="POST">
                    <div class="d-flex mb-3 gap-2 overflow-x-auto pb-2">
                        <button type="button" class="btn btn-sm btn-outline-danger px-3 rounded-pill" id="bulkDeleteBtn" disabled>
                            <i class="bi bi-trash me-1"></i> Hapus Terpilih
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary px-3 rounded-pill" id="bulkAlumniBtn" disabled>
                            <i class="bi bi-mortarboard me-1"></i> Tandai Alumni
                        </button>
                    </div>

                    <div class="table-responsive rounded-4 border">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="40"><input type="checkbox" class="form-check-input ms-2" id="checkAll"></th>
                                    <th class="ps-3">Nama Anggota</th>
                                    <th>NIM</th>
                                    <th class="text-center">Gen</th>
                                    <th>Divisi</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($allMembers)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="bi bi-person-x fs-1 d-block mb-2 opacity-25"></i>
                                            Data tidak ditemukan.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($allMembers as $m): ?>
                                        <tr>
                                            <td class="ps-3">
                                                <input type="checkbox" name="ids[]" class="form-check-input item-check" value="<?= $m['user_id'] ?>">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center py-1">
                                                    <?php $fotoProfile = !empty($m['foto_url']) ? $m['foto_url'] : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($m['nama_lengkap']); ?>
                                                    <img src="<?= htmlspecialchars($fotoProfile) ?>" class="rounded-circle me-3 border" width="40" height="40" style="object-fit: cover;">
                                                    <div>
                                                        <span class="fw-bold text-dark d-block small mb-0"><?= htmlspecialchars($m['nama_lengkap']) ?></span>
                                                        <small class="text-muted" style="font-size: 11px;"><?= htmlspecialchars($m['jabatan']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light text-primary border border-primary-subtle fw-bold"><?= htmlspecialchars($m['nim']) ?></span></td>
                                            <td class="text-center fw-bold text-muted"><?= htmlspecialchars($m['generasi'] ?? '-') ?></td>
                                            <td>
                                                <?php
                                                $divLabel = trim(explode(',', $m['divisi'] ?? '')[0]);
                                                $divClass = match ($divLabel) {
                                                    'Software' => 'bg-primary-subtle text-primary',
                                                    'Mekanik'  => 'bg-secondary-subtle text-secondary',
                                                    'Elektrik' => 'bg-warning-subtle text-warning',
                                                    'Humas'    => 'bg-info-subtle text-info',
                                                    default    => 'bg-light text-dark'
                                                };
                                                ?>
                                                <span class="badge <?= $divClass ?> rounded-pill px-3"><?= htmlspecialchars($m['divisi'] ?? 'N/A') ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                $statusLabel = strtolower($m['status_keanggotaan'] ?? 'active');
                                                $badgeClass = ($statusLabel == 'alumni') ? 'bg-danger' : 'bg-success';
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= ucfirst($statusLabel) ?></span>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="btn-group shadow-sm rounded-3 overflow-hidden border">
                                                    <a href="/admin/members/edit?id=<?= $m['id'] ?>" class="btn btn-sm btn-white py-2" title="Edit">
                                                        <i class="bi bi-pencil text-primary"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-white py-2 btn-delete-member" data-id="<?= $m['id'] ?>" title="Hapus">
                                                        <i class="bi bi-trash text-danger"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <footer class="mt-5 text-center py-4 border-top small text-muted">
                © <?= date("Y"); ?> <strong>EEPROM POLINEMA</strong> - Developed by Nisho
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Delete Satuan
            document.querySelectorAll('.btn-delete-member').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    if (confirm('Apakah Anda yakin ingin menghapus anggota ini? Akun login juga akan terhapus.')) {
                        window.location.href = `/admin/members/delete?id=${id}`;
                    }
                });
            });

            // Elemen-elemen Bulk
            const checkAll = document.getElementById('checkAll');
            const itemChecks = document.querySelectorAll('.item-check');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const bulkAlumniBtn = document.getElementById('bulkAlumniBtn');
            const bulkForm = document.getElementById('bulkActionForm');

            // Fungsi Update Status Tombol
            function updateBulkButtons() {
                const checkedCount = document.querySelectorAll('.item-check:checked').length;
                if (bulkDeleteBtn) bulkDeleteBtn.disabled = checkedCount === 0;
                if (bulkAlumniBtn) bulkAlumniBtn.disabled = checkedCount === 0;
            }

            // Event Centang Semua
            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    itemChecks.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateBulkButtons();
                });
            }

            // Event Centang Satuan
            itemChecks.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkButtons);
            });

            // Submit Bulk Delete
            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', function(e) {
                    if (confirm('Apakah Anda yakin ingin menghapus anggota yang dipilih?')) {
                        bulkForm.action = '/admin/members/bulkDelete';
                        bulkForm.submit();
                    }
                });
            }

            // Submit Bulk Alumni
            if (bulkAlumniBtn) {
                bulkAlumniBtn.addEventListener('click', function(e) {
                    if (confirm('Tandai anggota yang dipilih sebagai Alumni?')) {
                        bulkForm.action = '/admin/members/bulkAlumni';
                        bulkForm.submit();
                    }
                });
            }
        });
    </script>
</body>

</html>