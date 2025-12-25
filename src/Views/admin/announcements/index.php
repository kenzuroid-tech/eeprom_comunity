<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/announcements/index.css">
    
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
                    <h4 class="m-0 fw-bold">Announcements Management</h4>
                </div>

                <a href="/src/Views/admin/announcements/create.html" class="btn btn-create shadow-sm text-decoration-none">
                    <i class="bi bi-plus-lg me-2"></i>Buat Pengumuman
                </a>
            </nav>

            <div class="widget-card-admin">
                <h6 class="mb-3 fw-bold text-primary"><i class="bi bi-funnel me-2"></i>Filter Pengumuman</h6>
                <form class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Tipe Pengumuman</label>
                        <select class="form-select border-0 bg-light">
                            <option value="">Semua Tipe</option>
                            <option value="info">Informasi Umum</option>
                            <option value="urgent">Urgent / Penting</option>
                            <option value="event">Event / Kegiatan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Status Publikasi</label>
                        <select class="form-select border-0 bg-light">
                            <option value="">Semua Status</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-primary w-100 fw-bold" style="background-color: var(--primary-blue); border:none;">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="widget-card-admin p-0 border-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">Judul Pengumuman</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Published At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">Open Recruitment Anggota Baru 2024</div>
                                    <small class="text-muted">Oleh: Admin Utama</small>
                                </td>
                                <td><span class="badge-type type-event">Event</span></td>
                                <td>
                                    <span class="badge-status-dot bg-success"></span>
                                    <small class="fw-bold text-success">Published</small>
                                </td>
                                <td>15 Okt 2024, 08:30</td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm border rounded-2 bg-white">
                                        <button class="btn btn-sm px-3" title="Edit"><i class="bi bi-pencil-square text-warning"></i></button>
                                        <button class="btn btn-sm px-3 border-start" title="Delete"><i class="bi bi-trash text-danger"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">Draft: Rencana Workshop Robotika</div>
                                    <small class="text-muted">Oleh: Div. Software</small>
                                </td>
                                <td><span class="badge-type type-info">Informasi</span></td>
                                <td>
                                    <span class="badge-status-dot bg-secondary"></span>
                                    <small class="fw-bold text-secondary">Draft</small>
                                </td>
                                <td>-</td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm border rounded-2 bg-white">
                                        <button class="btn btn-sm px-3" title="Edit"><i class="bi bi-pencil-square text-warning"></i></button>
                                        <button class="btn btn-sm px-3 border-start" title="Delete"><i class="bi bi-trash text-danger"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan 2 dari 12 pengumuman</small>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
                            <li class="page-item active"><a class="page-link" href="#" style="background-color: var(--primary-blue); border-color: var(--primary-blue);">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/announcements/index.js"></script>
</body>

</html>