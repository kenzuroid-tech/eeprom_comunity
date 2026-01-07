<?php

/**
 * File: src/Views/admin/announcements/create.php
 */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengumuman Baru - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin/announcements/create.css">
</head>

<body>

    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area">
            <div class="container-fluid p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold m-0 text-dark">Buat Pengumuman Baru</h4>
                    <a href="/admin/announcements" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg me-1"></i>Batal</a>
                </div>

                <form action="/admin/announcements/store" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul Pengumuman</label>
                                    <input type="text" name="title" class="form-control" id="titleInput" placeholder="Masukkan judul..." required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Slug (URL Friendly)</label>
                                    <input type="text" name="slug" class="form-control bg-light" id="slugInput" readonly>
                                    <small class="text-muted">Slug akan dihasilkan otomatis dari judul.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Konten Pengumuman</label>
                                    <textarea name="content" class="form-control" rows="12" placeholder="Tulis konten pengumuman di sini..." required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="widget-card-admin bg-white p-4 rounded shadow-sm">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">Pengaturan</h6>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tipe / Kategori</label>
                                    <select name="category" class="form-select" required>
                                        <option value="info">Info</option>
                                        <option value="urgent">Urgent</option>
                                        <option value="event">Event</option>
                                    </select>
                                </div>
                                <!-- <div class="mb-4">
                                    <label class="form-label d-block fw-bold">Status Publikasi</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="statusDraft" value="Draft" checked>
                                        <label class="form-check-label" for="statusDraft">Draft</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="statusPub" value="Published">
                                        <label class="form-check-label text-success fw-bold" for="statusPub">Publish</label>
                                    </div>
                                </div> -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Lampiran File</label>
                                    <input type="file" name="attachments[]" class="form-control" multiple id="attachmentInput">
                                    <small class="text-muted mt-1 d-block">Bisa pilih lebih dari 1 file.</small>
                                    <div id="file-list" class="mt-2"></div>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" name="status" value="published" class="btn btn-primary fw-bold py-2 shadow-sm">
                                        <i class="bi bi-send-fill me-2"></i>Simpan & Publikasikan
                                    </button>

                                    <button type="submit" name="status" value="draft" class="btn btn-light border fw-bold py-2">
                                        <i class="bi bi-file-earmark-text me-2"></i>Simpan sebagai Draft
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Logika sederhana untuk menghasilkan Slug otomatis dari Judul
        const titleInput = document.getElementById('titleInput');
        const slugInput = document.getElementById('slugInput');

        titleInput.addEventListener('keyup', function() {
            let title = this.value;
            let slug = title.toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            slugInput.value = slug;
        });

        // Menampilkan nama file yang dipilih
        const fileInput = document.getElementById('attachmentInput');
        const fileList = document.getElementById('file-list');

        fileInput.addEventListener('change', function() {
            fileList.innerHTML = '';
            for (let i = 0; i < this.files.length; i++) {
                fileList.innerHTML += `<div class="small text-primary"><i class="bi bi-file-earmark-check me-1"></i>${this.files[i].name}</div>`;
            }
        });
    </script>
</body>

</html>