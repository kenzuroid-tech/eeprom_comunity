<?php

$adminData = $adminData ?? [];
$allMembers = $allMembers ?? [];
$totalAnggota = count($allMembers);

// Penanganan foto profil admin di navbar
$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($adminData['nama_lengkap'] ?? 'Admin');
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

        <div id="mainContentWrapper" class="main-content-area p-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <h4 class="m-0 fw-bold text-primary">Manajemen Anggota</h4>
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

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stat-card-admin shadow-sm bg-white p-3 rounded" style="border-left: 5px solid #28a745;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-check fs-2 me-3 text-success"></i>
                            <div>
                                <h3 class="m-0 fw-bold"><?= $totalAnggota ?></h3>
                                <p class="small m-0 text-muted">Total Anggota</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin bg-white p-4 rounded shadow-sm">
                <?php
                $current_status = $_GET['status'] ?? 'all';
                $searchParam = urlencode($_GET['search'] ?? '');
                $divisiParam = urlencode($_GET['filter_divisi'] ?? '');
                $generasiParam = urlencode($_GET['filter_generasi'] ?? '');
                ?>
                <ul class="nav nav-tabs nav-tabs-custom mb-4" id="memberTabs">
                    <li class="nav-item">
                        <a class="nav-link <?= $current_status == 'all' ? 'Active' : '' ?>"
                            href="?status=all&search=<?= urlencode($_GET['search'] ?? '') ?>">All Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_status == 'Active' ? 'Active' : '' ?>"
                            href="?status=Active&search=<?= urlencode($_GET['search'] ?? '') ?>">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_status == 'Alumni' ? 'Active' : '' ?>"
                            href="?status=Alumni&search=<?= urlencode($_GET['search'] ?? '') ?>">Alumni</a>
                    </li>
                </ul>

                <form action="" method="GET">
                    <div class="row g-3 mb-4 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Pencarian</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama atau NIM" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Divisi</label>
                            <select class="form-select" name="filter_divisi" onchange="this.form.submit()">
                                <option value="">Semua Divisi</option>
                                <option value="Software" <?= ($_GET['filter_divisi'] ?? '') == 'Software' ? 'selected' : '' ?>>Software</option>
                                <option value="Mekanik" <?= ($_GET['filter_divisi'] ?? '') == 'Mekanik' ? 'selected' : '' ?>>Mekanik</option>
                                <option value="Elektrik" <?= ($_GET['filter_divisi'] ?? '') == 'Elektrik' ? 'selected' : '' ?>>Elektrik</option>
                                <option value="Humas" <?= ($_GET['filter_divisi'] ?? '') == 'Humas' ? 'selected' : '' ?>>Humas</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Generasi</label>
                            <select class="form-select" name="filter_generasi">
                                <option value="">Semua Gen</option>
                                <?php for ($i = 1; $i <= 20; $i++): ?>
                                    <option value="<?= $i ?>" <?= ($_GET['filter_generasi'] ?? '') == $i ? 'selected' : '' ?>>Gen <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel"></i> Cari
                            </button>
                        </div>

                        <!-- <div class="col-md-3 text-end">
                            <button type="button" class="btn btn-outline-success me-1" title="Export Excel"><i class="bi bi-file-earmark-excel"></i></button>
                            <button type="button" class="btn btn-outline-danger" title="Export PDF"><i class="bi bi-file-earmark-pdf"></i></button>
                        </div> -->
                    </div>
                </form>

                <div class="d-flex mb-3 gap-2">
                    <button class="btn btn-sm btn-outline-danger" id="bulkDelete" disabled><i class="bi bi-trash"></i> Delete Selected</button>
                    <button class="btn btn-sm btn-outline-primary" id="bulkAlumni" disabled><i class="bi bi-mortarboard"></i> Mark as Alumni</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                <th>Profil</th>
                                <th>NIM</th>
                                <th>Gen</th>
                                <th>Divisi</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($allMembers)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Tidak ada data anggota ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($allMembers as $m): ?>
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input item-check" value="<?= $m['user_id'] ?>"></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php
                                                $fotoProfile = !empty($m['foto_url']) ? $m['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($m['nama_lengkap']);
                                                ?>
                                                <img src="<?= $fotoProfile ?>" class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                                                <span class="fw-bold text-dark"><?= htmlspecialchars($m['nama_lengkap']) ?></span>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($m['nim']) ?></td>
                                        <td><?= htmlspecialchars($m['generasi'] ?? '-') ?></td>
                                        <td>
                                            <?php
                                            $divClass = match ($m['divisi'] ?? '') {
                                                'Software' => 'bg-primary-subtle text-primary',
                                                'Mekanik' => 'bg-secondary-subtle text-secondary',
                                                'Elektrik' => 'bg-warning-subtle text-warning',
                                                default => 'bg-light text-dark'
                                            };
                                            ?>
                                            <span class="badge <?= $divClass ?>"><?= htmlspecialchars($m['divisi'] ?? 'N/A') ?></span>
                                        </td>
                                        <td>
                                            <?php
                                            $statusLabel = $m['status_keanggotaan'] ?? 'Active';
                                            $badgeClass = match (strtolower($statusLabel)) {
                                                'alumni' => 'bg-danger-subtle text-danger',
                                                'active' => 'bg-success-subtle text-success',
                                                // 'inactive' => 'bg-danger-subtle text-danger',
                                                default => 'bg-secondary-subtle text-secondary'
                                            };
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= ucfirst(htmlspecialchars($statusLabel)) ?></span>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group shadow-sm">
                                                <a href="/admin/members/edit?id=<?= $m['user_id'] ?>" class="btn btn-sm btn-light border text-primary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button class="btn btn-sm btn-light border text-danger" title="Hapus" onclick="return confirm('Hapus anggota ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <footer class="mt-5 text-center py-3 border-top small text-muted">
                © <?= date("Y"); ?> EEPROM POLINEMA - Developed by Nisho
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/members/index.js"></script>
</body>

</html>