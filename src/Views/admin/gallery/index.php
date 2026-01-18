<?php

/**
 * Data dari GalleryController
 * @var array $galleries  Data foto dari tabel gallery
 * @var array $adminData  Data profil admin untuk navbar & sidebar
 */
$galleries = $galleries ?? [];

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
    <title>Gallery Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/gallery/index.css">
    <style>
        :root {
            --primary-blue: #1A237E;
            --accent-orange: #FF5722;
        }

        .main-content-area {
            padding: 30px;
            transition: 0.3s;
        }

        .gallery-thumb {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }

        .gallery-item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .gallery-item:hover {
            transform: translateY(-5px);
        }

        .btn-upload {
            background: var(--accent-orange);
            color: white;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-upload:hover {
            background: #e64a19;
            color: white;
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
                    <h4 class="m-0 fw-bold text-dark">Admin Dashboard - Gallery</h4>
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <button class="btn btn-upload px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="bi bi-cloud-arrow-up me-2"></i>Upload Foto Baru
                </button>
            </div>

            <div class="bg-white p-4 rounded-3 shadow-sm mb-4">
                <form class="row g-3" method="GET" action="/admin/gallery">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Cari Judul</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Ketik judul..." value="<?= $_GET['search'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Kategori</label>
                        <select name="category" class="form-select bg-light border-0">
                            <option value="">Semua Kategori</option>
                            <option value="Kegiatan" <?= (($_GET['category'] ?? '') == 'Kegiatan') ? 'selected' : '' ?>>Kegiatan</option>
                            <option value="Lomba" <?= (($_GET['category'] ?? '') == 'Lomba') ? 'selected' : '' ?>>Lomba</option>
                            <option value="Internal" <?= (($_GET['category'] ?? '') == 'Internal') ? 'selected' : '' ?>>Internal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Tahun</label>
                        <select name="year" class="form-select bg-light border-0">
                            <option value="">Pilih Tahun</option>
                            <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                <option value="<?= $y ?>" <?= (($_GET['year'] ?? '') == $y) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 fw-bold" style="background: var(--primary-blue);">Terapkan Filter</button>
                    </div>
                </form>
            </div>

            <div class="row g-4" id="galleryGrid">
                <?php if (empty($galleries)): ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-image text-muted fs-1"></i>
                        <p class="text-muted mt-2">Data galeri tidak ditemukan.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($galleries as $item): ?>
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <div class="gallery-item h-100">
                                <input type="checkbox" class="gallery-checkbox item-check" value="<?= $item['id'] ?>" style="position: absolute; top: 10px; left: 10px; z-index: 10;">
                                <img src="<?= htmlspecialchars($item['image_url']) ?>" class="gallery-thumb" alt="<?= htmlspecialchars($item['title']) ?>">
                                <div class="gallery-content p-3">
                                    <h6 class="fw-bold mb-1 text-truncate"><?= htmlspecialchars($item['title']) ?></h6>
                                    <span class="badge bg-light text-primary mb-2"><?= htmlspecialchars($item['category']) ?></span>
                                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                        <small class="text-muted"><i class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($item['event_date'])) ?></small>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary border-0" onclick="editGallery(<?= $item['id'] ?>)"><i class="bi bi-pencil-square"></i></button>
                                            <a href="/admin/gallery/delete?id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus foto ini?')"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <form action="/admin/gallery/store" method="POST" enctype="multipart/form-data">
                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                        <h5 class="fw-bold text-dark"><i class="bi bi-file-earmark-arrow-up me-2"></i>Upload Photo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Judul Foto/Kegiatan</label>
                            <input type="text" name="title" class="form-control border-0 bg-light" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Kategori</label>
                                <select name="category" class="form-select border-0 bg-light" required>
                                    <option value="Kegiatan">Kegiatan</option>
                                    <option value="Lomba">Lomba</option>
                                    <option value="Internal">Internal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Tanggal Pelaksanaan</label>
                                <input type="date" name="event_date" class="form-control border-0 bg-light" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Pilih File Gambar</label>
                            <input type="file" name="photos[]" class="form-control border-0 bg-light p-3" multiple accept="image/*" required>
                            <small class="text-muted">Dapat memilih lebih dari satu gambar (Max 5MB/file).</small>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-upload px-4 shadow-sm">Mulai Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>