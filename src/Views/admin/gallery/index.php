<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/img/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/gallery/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center bg-white shadow-sm p-3 rounded-3 mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold text-dark">Gallery Management</h4>
                </div>
                <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="bi bi-cloud-arrow-up me-2"></i>Upload Foto
                </button>
            </nav>

            <div class="bg-white p-4 rounded-3 shadow-sm mb-4">
                <form class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Search Title</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control bg-light border-0" placeholder="Cari foto...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Kategori</label>
                        <select class="form-select bg-light border-0">
                            <option selected>Semua Kategori</option>
                            <option>Kegiatan</option>
                            <option>Lomba</option>
                            <option>Internal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Tahun</label>
                        <select class="form-select bg-light border-0">
                            <option selected>Pilih Tahun</option>
                            <option>2024</option>
                            <option>2023</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" class="btn btn-primary w-100 fw-bold" style="background: var(--primary-blue);">Filter</button>
                    </div>
                </form>
            </div>

            <div class="row g-4" id="galleryGrid">
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <div class="gallery-item">
                        <input type="checkbox" class="gallery-checkbox item-check">
                        <!-- <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=500" class="gallery-thumb" alt="Workshop"> -->
                        <div class="gallery-content">
                            <h6 class="fw-bold mb-1 text-truncate">Workshop Arduino 2024</h6>
                            <span class="badge bg-light text-primary mb-2">Kegiatan</span>
                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                <small class="text-muted"><i class="bi bi-calendar-event me-1"></i>12 Jan 2024</small>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary border-0" title="Edit"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-sm btn-outline-danger border-0" title="Hapus"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <div class="gallery-item">
                        <input type="checkbox" class="gallery-checkbox item-check">
                        <!-- <img src="https://images.unsplash.com/photo-1531297484001-80022131f5a1?auto=format&fit=crop&w=500" class="gallery-thumb" alt="Lomba"> -->
                        <div class="gallery-content">
                            <h6 class="fw-bold mb-1 text-truncate">KRI Wilayah II 2023</h6>
                            <span class="badge bg-light text-primary mb-2">Lomba</span>
                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                <small class="text-muted"><i class="bi bi-calendar-event me-1"></i>05 Jun 2023</small>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary border-0"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 d-flex justify-content-center">
                <nav>
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#" style="background: var(--primary-blue); border-color: var(--primary-blue);">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="bulk-action-bar" id="bulkBar">
        <span class="fw-bold"><span id="selectedCount">0</span> Foto Terpilih</span>
        <button class="btn btn-danger btn-sm fw-bold px-4 rounded-pill" onclick="confirmDeleteSelected()">
            <i class="bi bi-trash me-2"></i>Delete Selected
        </button>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark">Upload Multiple Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="upload-zone border-2 border-dashed rounded-4 p-5 text-center bg-light" id="dropZone">
                        <i class="bi bi-images fs-1 text-muted mb-3 d-block"></i>
                        <h6 class="fw-bold mb-1">Drag and drop files here</h6>
                        <p class="text-muted small mb-3">Max 10 files sekaligus (Format: JPG, PNG)</p>
                        <input type="file" id="fileInput" multiple accept="image/*" class="d-none">
                        <button class="btn btn-primary px-4 fw-bold" style="background: var(--primary-blue);" onclick="document.getElementById('fileInput').click()">Pilih File</button>
                    </div>

                    <div class="upload-preview-container" id="previewContainer">
                        </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-upload shadow-sm px-4">Simpan Galeri</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/gallery/index.js"></script>
</body>
</html>