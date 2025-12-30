<?php
/**
 * File: src/Views/admin/members/index.php
 */
$adminData = $adminData ?? [];
$allMembers = $allMembers ?? [];
$totalAnggota = count($allMembers);

// Penanganan foto profil admin di navbar
$adminFoto = !empty($adminData['foto_url']) ? $adminData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($adminData['nama_lengkap'] ?? 'Admin');
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
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <h4 class="m-0 fw-bold text-primary">Manajemen Anggota</h4>
                <div class="d-flex align-items-center">
                    <span class="me-3 fw-bold small"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Admin') ?></span>
                    <img src="<?= $adminFoto ?>" width="35" height="35" class="rounded-circle border" style="object-fit: cover;">
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
                <ul class="nav nav-tabs nav-tabs-custom mb-4" id="memberTabs">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#all">All Members</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#active">Active</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#alumni">Alumni</a></li>
                </ul>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <form action="" method="GET" class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama atau NIM..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </form>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="filter_divisi">
                            <option value="">Semua Divisi</option>
                            <option value="Software">Software</option>
                            <option value="Mekanik">Mekanik</option>
                            <option value="Elektrik">Elektrik</option>
                        </select>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-outline-success me-2"><i class="bi bi-file-earmark-excel"></i> Excel</button>
                        <button class="btn btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
                    </div>
                </div>

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
                                                $divClass = match($m['divisi'] ?? '') {
                                                    'Software' => 'bg-primary-subtle text-primary',
                                                    'Mekanik' => 'bg-secondary-subtle text-secondary',
                                                    'Elektrik' => 'bg-warning-subtle text-warning',
                                                    default => 'bg-light text-dark'
                                                };
                                            ?>
                                            <span class="badge <?= $divClass ?>"><?= htmlspecialchars($m['divisi'] ?? 'N/A') ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success">Active</span>
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
                © <?= date("Y"); ?> EEPROM POLINEMA - Admin Panel
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/members/index.js"></script>
</body>
</html>