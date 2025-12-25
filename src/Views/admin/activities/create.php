<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Aktivitas Baru - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/imgages/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/activities/create.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Tambah Aktivitas Baru</h4>
                </div>
            </nav>

            <form id="activityForm">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="widget-card-admin shadow-sm">
                            <div class="mb-4">
                                <label class="form-label">Judul Aktivitas</label>
                                <input type="text" class="form-control" id="titleInput" placeholder="Contoh: Workshop Robotika Nasional" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Slug (URL Name)</label>
                                <input type="text" class="form-control" id="slugInput" placeholder="workshop-robotika-nasional">
                                <small class="text-muted mt-1">Slug akan otomatis terisi dari judul, namun Anda dapat merubahnya.</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Deskripsi Singkat (Max 200 Karakter)</label>
                                <textarea class="form-control" id="shortDesc" rows="2" maxlength="200" placeholder="Ringkasan aktivitas untuk ditampilkan di thumbnail..."></textarea>
                                <div class="text-end small text-muted" id="charCount">0/200</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Deskripsi Lengkap</label>
                                <div class="border rounded p-2 bg-light mb-2"><small><i class="bi bi-info-circle me-1"></i> Rich Text Editor Placeholder</small></div>
                                <textarea class="form-control" rows="12" placeholder="Tuliskan detail aktivitas, rangkaian acara, dll..."></textarea>
                            </div>
                        </div>

                        <div class="widget-card-admin shadow-sm">
                            <h5 class="fw-bold mb-4">Gallery Images</h5>
                            <label class="form-label">Pilih Foto Galeri (Bisa pilih lebih dari satu)</label>
                            <input type="file" class="form-control mb-3" id="galleryInput" multiple accept="image/*">
                            <div class="gallery-grid" id="galleryPreview">
                                </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="widget-card-admin shadow-sm text-center">
                            <h5 class="fw-bold mb-4 text-start">Featured Image</h5>
                            <div class="preview-container" id="featuredPreview">
                                <div class="text-center p-3">
                                    <i class="bi bi-image fs-1 text-muted"></i>
                                    <p class="small text-muted mb-0">Klik tombol di bawah untuk memilih foto utama</p>
                                </div>
                            </div>
                            <input type="file" class="form-control d-none" id="featuredInput" accept="image/*">
                            <button type="button" class="btn btn-outline-primary w-100" onclick="document.getElementById('featuredInput').click()">
                                <i class="bi bi-upload me-2"></i>Pilih Foto Utama
                            </button>
                        </div>

                        <div class="widget-card-admin shadow-sm">
                            <h5 class="fw-bold mb-4">Detail Pelaksanaan</h5>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select">
                                    <option selected disabled>Pilih Kategori...</option>
                                    <option>Internal Community</option>
                                    <option>Competition</option>
                                    <option>Workshop/Seminar</option>
                                    <option>Social Project</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pelaksanaan</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" placeholder="Contoh: Gedung AH Lantai 2">
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-save flex-grow-1">Save Activity</button>
                            <a href="/admin/activities/index.php" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/activities/create.js"></script>
</body>
</html>