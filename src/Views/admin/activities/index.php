<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/activities/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="m-0 fw-bold">Activities Management</h4>
                </div>
            </nav>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0 text-primary-blue fw-bold">Daftar Aktivitas Komunitas</h2>
                <a href="/admin/activities-create.html" class="btn btn-primary-custom">
                    <i class="bi bi-plus-circle-fill me-2"></i> Tambah Activity
                </a>
            </div>

            <div class="widget-card-admin mb-4">
                <h5 class="fw-bold text-primary-blue mb-3">Filter Data</h5>
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" class="form-control" placeholder="Cari berdasarkan Judul...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option selected>Filter Kategori</option>
                            <option>Pelatihan</option>
                            <option>Workshop</option>
                            <option>Lomba</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select">
                            <option selected>2025</option>
                            <option>2024</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary w-100"><i class="bi bi-funnel-fill"></i> Apply</button>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="table-light">
                                <th>Featured Image</th>
                                <th>Judul Aktivitas</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="/img/activity_thumb_1.jpg" class="featured-image-thumb" alt="Thumbnail"></td>
                                <td>Workshop Robot Line Follower</td>
                                <td><span class="badge bg-info text-dark">Pelatihan</span></td>
                                <td>2025-01-15</td>
                                <td>
                                    <button class="btn btn-sm btn-light text-primary"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/activities/index.js"></script>
</body>

</html>