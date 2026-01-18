<?php
// Data dari Controller
$adminData = $adminData ?? [];
$divisions = $divisions ?? []; // Pastikan variabel ini dikirim dari controller
$totalDivisions = $totalDivisions ?? 0;
$totalMembers = $totalMembers ?? 0;
$largestDivision = $largestDivision ?? '-';
$avgMembers = $avgMembers ?? 0;
$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($adminData['nama_lengkap'] ?? 'Admin');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divisions Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin/divisions/index.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <style>
        .stat-card-admin {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 1.2rem;
            min-height: 100px;
        }

        .stat-info h3 {
            font-size: 1.4rem !important;
            margin: 0;
            font-weight: 700;
            line-height: 1.2;
        }

        .stat-info p {
            font-size: 0.85rem !important;
            margin: 0;
            color: #6c757d;
        }

        .division-icon-img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold text-primary">Divisions Management</h4>
                </div>
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
                    <div class="stat-card-admin bg-white rounded shadow-sm" style="border-left: 5px solid #0d6efd;">
                        <div class="stat-icon-wrapper text-primary fs-2">
                            <i class="bi bi-folder"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?= $totalDivisions ?></h3>
                            <p>Total Divisi</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card-admin bg-white rounded shadow-sm" style="border-left: 5px solid #28a745;">
                        <div class="stat-icon-wrapper text-success fs-2">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?= $totalMembers ?></h3>
                            <p>Anggota</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card-admin bg-white rounded shadow-sm" style="border-left: 5px solid #ffc107;">
                        <div class="stat-icon-wrapper text-warning fs-2">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <div class="stat-info">
                            <h3 class="text-truncate" style="max-width: 120px;"><?= $largestDivision ?></h3>
                            <p>Terbanyak</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card-admin bg-white rounded shadow-sm" style="border-left: 5px solid #dc3545;">
                        <div class="stat-icon-wrapper text-danger fs-2">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?= $avgMembers ?></h3>
                            <p>Rata-rata</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin bg-white rounded shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40"></th>
                                <th width="60">No</th>
                                <th width="100">Icon</th>
                                <th>Nama Divisi</th>
                                <th>Deskripsi</th>
                                <th width="150">Anggota</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($divisions)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data divisi.</td>
                                </tr>
                                <?php else: $no = 1;
                                foreach ($divisions as $d): ?>
                                    <tr>
                                        <td><i class="bi bi-list text-muted drag-handle"></i></td>
                                        <td><?= $no++ ?></td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center bg-light rounded" style="width: 50px; height: 50px; overflow: hidden;">
                                                <?php
                                                $icon = $d['icon'];
                                                // Cek apakah icon berisi path (mengandung '/' atau '.')
                                                if (strpos($icon, '/') !== false || strpos($icon, '.') !== false):
                                                    // Tambahkan /public jika gambar tidak muncul, atau hapus jika path sudah lengkap
                                                    $finalPath = $icon;
                                                ?>
                                                    <img src="<?= htmlspecialchars($finalPath) ?>"
                                                        class="division-icon-img"
                                                        style="width: 100%; height: 100%; object-fit: contain;"
                                                        onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?= urlencode($d['name']) ?>&background=random';">
                                                <?php else: ?>
                                                    <span class="fs-4"><?= htmlspecialchars($icon) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-primary"><?= htmlspecialchars($d['name']) ?></td>
                                        <td>
                                            <div class="text-muted small text-truncate" style="max-width: 250px;">
                                                <?= htmlspecialchars($d['description']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">
                                                <?= $d['member_count'] ?> Anggota
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm">
                                                <a href="/admin/members?search=<?= urlencode($d['name']) ?>" class="btn btn-sm btn-white border text-primary" title="Lihat Anggota">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="/admin/divisions/edit?id=<?= $d['id'] ?>" class="btn btn-sm btn-white border text-warning" title="Edit Divisi">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button class="btn btn-sm btn-white border text-danger" title="Hapus Divisi">
                                                    <i class="bi bi-trash"></i>
                                                </button>
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
    <script src="/assets/js/admin/divisions/index.js"></script>

</body>

</html>