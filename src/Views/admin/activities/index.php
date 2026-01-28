<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/activities/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center p-3">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Management Aktivitas</h4>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?= $adminData['foto_url'] ?? 'https://ui-avatars.com/api/?name=Admin' ?>" alt="Profile" width="35" class="rounded-circle me-2">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= $adminData['nama_lengkap'] ?? 'Admin' ?></span>
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- <h2 class="h4 mb-0 text-primary fw-bold">Daftar Aktivitas Komunitas</h2> -->
                <a href="/admin/activities/create" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-plus-circle-fill me-2"></i> Tambah Activity
                </a>
            </div>

            <div class="bg-white p-4 rounded shadow-sm mb-4">
                <form action="/admin/activities" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Judul..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Pelatihan">Pelatihan</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Lomba">Lomba</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel-fill me-1"></i> Filter</button>
                    </div>
                    <div class="col-md-2">
                        <a href="/admin/activities" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bg-white p-4 rounded shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted small">
                                <th>GAMBAR</th>
                                <th>JUDUL AKTIVITAS</th>
                                <th>KATEGORI</th>
                                <th>TANGGAL</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($activities)): ?>
                                <?php foreach ($activities as $act): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= htmlspecialchars($act['image_url'] ?? '/assets/images/default-activity.jpg') ?>"
                                                class="rounded" style="width: 80px; height: 50px; object-fit: cover;" alt="Thumb">
                                        </td>
                                        <td class="fw-bold"><?= htmlspecialchars($act['title']) ?></td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info px-3"><?= htmlspecialchars($act['type'] ?? 'Umum') ?></span>
                                        </td>
                                        <td class="small text-muted">
                                            <?= date('d M Y', strtotime($act['created_at'])) ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="/admin/activities/edit?id=<?= $act['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete(<?= $act['id'] ?>)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada data aktivitas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus aktivitas ini?')) {
                window.location.href = '/admin/activities/delete?id=' + id;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>