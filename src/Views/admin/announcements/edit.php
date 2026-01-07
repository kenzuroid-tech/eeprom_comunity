<?php
/**
 * File: src/Views/admin/announcements/edit.php
 */
$announcement = $announcement ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengumuman - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin/announcements/edit.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold m-0 text-dark">Edit Pengumuman</h4>
                    <small class="text-muted">
                        Terakhir diupdate: <?= isset($announcement['updated_at']) ? date('d M Y', strtotime($announcement['updated_at'])) : date('d M Y', strtotime($announcement['created_at'])) ?>
                    </small>
                </div>
                <a href="/admin/announcements" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg me-1"></i>Batal</a>
            </div>

            <form action="/admin/announcements/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $announcement['id'] ?>">

                <div class="row">
                    <div class="col-lg-8">
                        <div class="widget-card-admin bg-white p-4 rounded shadow-sm">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Pengumuman</label>
                                <input type="text" name="title" class="form-control" id="titleInput" 
                                       value="<?= htmlspecialchars($announcement['title']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Slug</label>
                                <input type="text" name="slug" class="form-control bg-light" id="slugInput" 
                                       value="<?= htmlspecialchars($announcement['slug'] ?? '') ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Konten Pengumuman</label>
                                <textarea name="content" class="form-control" rows="12" required><?= htmlspecialchars($announcement['content']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="widget-card-admin bg-white p-4 rounded shadow-sm">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">Status & Tipe</h6>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipe</label>
                                <select name="category" class="form-select" required>
                                    <option value="info" <?= $announcement['category'] == 'info' ? 'selected' : '' ?>>Info</option>
                                    <option value="urgent" <?= $announcement['category'] == 'urgent' ? 'selected' : '' ?>>Urgent</option>
                                    <option value="event" <?= $announcement['category'] == 'event' ? 'selected' : '' ?>>Event</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label d-block fw-bold">Status Saat Ini</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="statusDraft" value="Draft" 
                                           <?= ($announcement['status'] ?? '') == 'Draft' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="statusDraft">Draft</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="statusPub" value="Published" 
                                           <?= ($announcement['status'] ?? 'Published') == 'Published' ? 'checked' : '' ?>>
                                    <label class="form-check-label text-success fw-bold" for="statusPub">Published</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ganti Lampiran</label>
                                <input type="file" name="attachments[]" class="form-control" multiple>
                                <div class="mt-2 small text-muted">
                                    <i class="bi bi-info-circle me-1"></i> Pilih file baru untuk mengganti lampiran lama.
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Update & Publish
                            </button>
                            <a href="/admin/announcements" class="btn btn-light border fw-bold py-2">Kembali</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-slug generator jika judul diubah
        const titleInput = document.getElementById('titleInput');
        const slugInput = document.getElementById('slugInput');

        titleInput.addEventListener('keyup', function() {
            let slug = this.value.toLowerCase()
                            .replace(/[^\w ]+/g, '')
                            .replace(/ +/g, '-');
            slugInput.value = slug;
        });
    </script>
</body>
</html>