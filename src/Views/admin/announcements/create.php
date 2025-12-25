<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengumuman Baru - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/announcements/create.css">

</head>
<body>

    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0 text-dark">Buat Pengumuman Baru</h4>
                <a href="/admin/announcements.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg me-1"></i>Batal</a>
            </div>

            <form action="save.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="widget-card-admin">
                            <div class="mb-3">
                                <label class="form-label">Judul Pengumuman</label>
                                <input type="text" class="form-control" id="titleInput" placeholder="Masukkan judul..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug (Auto-generated)</label>
                                <input type="text" class="form-control bg-light" id="slugInput" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konten Pengumuman</label>
                                <div class="border rounded p-2 bg-light text-muted small mb-2"><i class="bi bi-info-circle me-1"></i>Rich Text Editor Placeholder</div>
                                <textarea class="form-control" rows="10" placeholder="Tulis konten pengumuman di sini..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="widget-card-admin">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">Pengaturan</h6>
                            <div class="mb-3">
                                <label class="form-label">Tipe</label>
                                <select class="form-select" required>
                                    <option value="Info">Info</option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="Event">Event</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="statusDraft" value="Draft" checked>
                                    <label class="form-check-label" for="statusDraft">Draft</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="statusPub" value="Published">
                                    <label class="form-check-label text-success fw-bold" for="statusPub">Publish</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lampiran File (Multiple)</label>
                                <input type="file" class="form-control" multiple id="attachmentInput">
                                <div id="file-list" class="mt-2"></div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2" style="background-color: var(--primary-blue);">Publish Now</button>
                            <button type="button" class="btn btn-light border fw-bold py-2">Save as Draft</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/announcements/create.js"></script>
</body>
</html>