<?php

/**
 * Data dari DocumentController
 * @var array $documents  Daftar dokumen dari tabel documents
 * @var array $adminData  Data profil admin untuk navbar & sidebar
 */
$documents = $documents ?? [];

// Logika Foto Profil Admin untuk Navbar
$adminFotoNavbar = !empty($adminData['foto_url'])
    ? $adminData['foto_url']
    : '/assets/images/default-avatar.png';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <style>
        :root {
            --primary-blue: #1A237E;
            --secondary-blue: #3F51B5;
            --accent-orange: #FF5722;
            --bg-gray: #F1F5F9;
            --sidebar-width: 280px;
        }

        body {
            background-color: var(--bg-gray);
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        /* --- Layout Adjustment agar tidak tertutup Sidebar --- */
        .main-content-area {
            margin-left: calc(var(--sidebar-width) + 20px);
            /* Memberi ruang untuk sidebar melayang */
            padding: 30px;
            transition: 0.3s;
            min-height: 100vh;
        }

        /* --- Navbar & Card Styling --- */
        .navbar {
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .widget-card-admin {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        /* --- Button Upload Custom --- */
        .btn-upload {
            background-color: var(--accent-orange);
            color: white;
            font-weight: 700;
            border-radius: 12px;
            border: none;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(255, 87, 34, 0.2);
        }

        .btn-upload:hover {
            background-color: #E64A19;
            color: white;
            transform: translateY(-2px);
        }

        /* --- Table Icons & Typography --- */
        .doc-icon {
            font-size: 1.8rem;
        }

        .icon-pdf {
            color: #E91E63;
        }

        /* Warna merah PDF lebih modern */
        .icon-doc {
            color: #1976D2;
        }

        /* Warna biru Word */
        .icon-xls {
            color: #2E7D32;
        }

        /* Warna hijau Excel */

        .table thead th {
            background-color: #F8FAFC;
            color: #64748B;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 15px;
            border: none;
        }

        .table tbody td {
            padding: 18px 15px;
            border-bottom: 1px solid #F1F5F9;
        }

        /* --- Form Controls --- */
        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 10px 15px;
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
        }

        /* --- Responsive Layout --- */
        @media (max-width: 991.98px) {
            .main-content-area {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold text-dark">Management Dokumen</h4>
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

            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-upload px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalUpload">
                    <i class="bi bi-cloud-arrow-up me-2"></i>Upload New Document
                </button>
            </div>

            <div class="widget-card-admin">
                <form class="row g-3" method="GET" action="/admin/documents">
                    <div class="col-md-5">
                        <label class="form-label fw-bold small">Cari Dokumen</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Ketik judul file..." value="<?= $_GET['search'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Filter Kategori</label>
                        <select name="category" class="form-select bg-light border-0">
                            <option value="">Semua Kategori</option>
                            <option value="LPJ">Laporan Pertanggungjawaban</option>
                            <option value="Proposal">Proposal Kegiatan</option>
                            <option value="Materi">Materi Workshop</option>
                            <option value="Surat">Surat Menyurat</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 fw-bold" style="background-color: var(--primary-blue);">Terapkan Filter</button>
                    </div>
                </form>
            </div>

            <div class="widget-card-admin p-0 border-0 overflow-hidden shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" width="80">Icon</th>
                                <th>Judul Dokumen</th>
                                <th>Kategori</th>
                                <th>File Size</th>
                                <th>Upload Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($documents)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada dokumen yang ditemukan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($documents as $doc):
                                    $ext = pathinfo($doc['file_path'], PATHINFO_EXTENSION);
                                    $iconClass = 'bi-file-earmark-fill';
                                    $colorClass = 'text-secondary';
                                    if ($ext == 'pdf') {
                                        $iconClass = 'bi-file-earmark-pdf-fill';
                                        $colorClass = 'icon-pdf';
                                    } elseif (in_array($ext, ['doc', 'docx'])) {
                                        $iconClass = 'bi-file-earmark-word-fill';
                                        $colorClass = 'icon-doc';
                                    } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                        $iconClass = 'bi-file-earmark-excel-fill';
                                        $colorClass = 'icon-xls';
                                    }
                                ?>
                                    <tr>
                                        <td class="ps-4 text-center"><i class="bi <?= $iconClass ?> doc-icon <?= $colorClass ?>"></i></td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($doc['title']) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($doc['description'] ?? 'No description') ?></small>
                                        </td>
                                        <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($doc['category']) ?></span></td>
                                        <td><?= $doc['file_size'] ?? 'N/A' ?></td>
                                        <td><?= isset($doc['created_at']) ? date('d M Y', strtotime($doc['created_at'])) : 'N/A' ?></td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm rounded">
                                                <a href="<?= $doc['file_path'] ?>" target="_blank" class="btn btn-sm btn-white text-primary" title="Download"><i class="bi bi-download"></i></a>
                                                <a href="/admin/documents/delete?id=<?= $doc['id'] ?>" class="btn btn-sm btn-white text-danger" title="Delete" onclick="return confirm('Hapus dokumen ini?')"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpload" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-primary"><i class="bi bi-file-earmark-arrow-up me-2"></i>Upload Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/documents/store" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">File Dokumen</label>
                            <input type="file" name="document_file" class="form-control border-0 bg-light p-3" required>
                            <small class="text-muted mt-1 d-block">Max: 10MB (PDF, DOC, XLS, ZIP)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Judul Dokumen</label>
                            <input type="text" name="title" class="form-control bg-light border-0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Kategori</label>
                            <select name="category" class="form-select bg-light border-0">
                                <option value="LPJ">Laporan Pertanggungjawaban</option>
                                <option value="Proposal">Proposal Kegiatan</option>
                                <option value="Materi">Materi Workshop</option>
                                <option value="Surat">Surat Menyurat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Deskripsi</label>
                            <textarea name="description" class="form-control bg-light border-0" rows="3"></textarea>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary fw-bold py-2" style="background-color: var(--primary-blue);">
                                <i class="bi bi-save me-2"></i>Save & Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>