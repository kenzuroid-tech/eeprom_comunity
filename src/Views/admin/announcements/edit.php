<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengumuman - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/public/assets/css/admin/announcements/edit.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
  
</head>
<body>

    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold m-0 text-dark">Edit Pengumuman</h4>
                    <small class="text-muted">Terakhir diupdate: 20 Des 2025</small>
                </div>
                <a href="/admin/announcements.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg me-1"></i>Batal</a>
            </div>

            <form action="update.php" method="POST">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="widget-card-admin">
                            <div class="mb-3">
                                <label class="form-label">Judul Pengumuman</label>
                                <input type="text" class="form-control" id="titleInput" value="Open Recruitment Anggota Baru 2024">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control bg-light" id="slugInput" value="open-recruitment-anggota-baru-2024" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konten Pengumuman</label>
                                <textarea class="form-control" rows="10">Membuka pendaftaran bagi mahasiswa aktif angkatan 2023 dan 2024...</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="widget-card-admin">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">Status & Tipe</h6>
                            <div class="mb-3">
                                <label class="form-label">Tipe</label>
                                <select class="form-select">
                                    <option value="Info">Info</option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="Event" selected>Event</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label d-block">Status Saat Ini</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="statusDraft" value="Draft">
                                    <label class="form-check-label" for="statusDraft">Draft</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="statusPub" value="Published" checked>
                                    <label class="form-check-label text-success fw-bold" for="statusPub">Published</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ganti Lampiran</label>
                                <input type="file" class="form-control" multiple>
                                <div class="mt-2 small text-muted">
                                    <div class="mb-1"><i class="bi bi-paperclip me-1"></i>poster_recruitment.jpg <span class="text-danger">(Hapus)</span></div>
                                    <div><i class="bi bi-paperclip me-1"></i>syarat_pendaftaran.pdf <span class="text-danger">(Hapus)</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2" style="background-color: var(--primary-blue);">Update & Publish</button>
                            <a href="/admin/announcements.php" class="btn btn-light border fw-bold py-2">Kembali</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/announcements/edit.js"></script>
</body>
</html>