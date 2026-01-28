<?php
$achievements = $achievements ?? [];
$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : '/assets/images/default-avatar.png';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Achievement Management - EEPROM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin/achievements/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <h4 class="m-0 fw-bold">Achievement Management</h4>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?= $adminFotoNavbar ?>" width="35" height="35" class="rounded-circle me-2">
                        <span class="text-dark fw-bold"><?= $adminData['nama_lengkap'] ?? 'Admin' ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item" href="/logout">Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-3">Tambah Prestasi Baru</h5>
                <form action="/admin/achievement/store" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6"><input type="text" name="title" class="form-control" placeholder="Judul Prestasi" required></div>
                        <div class="col-md-3"><input type="text" name="rank" class="form-control" placeholder="Peringkat (Juara 1)"></div>
                        <div class="col-md-3"><input type="number" name="year" class="form-control" placeholder="Tahun" value="<?= date('Y') ?>"></div>
                        <div class="col-md-12"><input type="text" name="event_name" class="form-control" placeholder="Nama Event/Lomba"></div>
                        <div class="col-md-12"><textarea name="description" class="form-control" placeholder="Deskripsi singkat"></textarea></div>
                        <div class="col-md-3"><button type="submit" class="btn btn-primary w-100">Simpan Prestasi</button></div>
                    </div>
                </form>
            </div>

            <div class="card border-0 shadow-sm p-0 overflow-hidden">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tahun</th>
                            <th>Prestasi</th>
                            <th>Event</th>
                            <th>Peringkat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($achievements as $row): ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?= $row['year'] ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['event_name']) ?></td>
                                <td><span class="badge bg-success"><?= htmlspecialchars($row['rank']) ?></span></td>
                                <td class="text-center">
                                    <a href="/admin/achievement/delete?id=<?= $row['id'] ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="/assets/js/admin/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>