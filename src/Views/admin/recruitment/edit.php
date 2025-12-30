<?php
/**
 * File: src/Views/admin/recruitment/edit.php
 */
$adminData = $adminData ?? [];
$period = $period ?? [];
$divisions = $divisions ?? []; 
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recruitment - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin/recruitment/edit.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold m-0 text-dark">Edit Recruitment</h4>
                    <small class="text-muted">ID: #REC-<?= date('Y', strtotime($period['created_at'] ?? 'now')) ?>-<?= str_pad($period['id'] ?? '0', 3, '0', STR_PAD_LEFT) ?></small>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/admin/recruitment">Recruitment</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>

            <form action="/admin/recruitment/update" method="POST">
                <input type="hidden" name="id" value="<?= $period['id'] ?>">

                <div class="row">
                    <div class="col-lg-8">
                        <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Detail Recruitment</h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nama Periode Recruitment</label>
                                <input type="text" name="nama_periode" class="form-control" value="<?= htmlspecialchars($period['nama_periode'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Deskripsi Singkat</label>
                                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($period['description'] ?? '') ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Semester</label>
                                    <select name="semester" class="form-select">
                                        <option value="Ganjil" <?= ($period['semester'] ?? '') == 'Ganjil' ? 'selected' : '' ?>>Ganjil</option>
                                        <option value="Genap" <?= ($period['semester'] ?? '') == 'Genap' ? 'selected' : '' ?>>Genap</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Tahun Akademik</label>
                                    <input type="text" name="tahun_akademik" class="form-control" value="<?= htmlspecialchars($period['tahun_akademik'] ?? '') ?>" placeholder="2024/2025">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Tanggal Mulai</label>
                                    <input type="datetime-local" name="tanggal_mulai" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($period['tanggal_mulai'] ?? 'now')) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Tanggal Selesai</label>
                                    <input type="datetime-local" name="tanggal_selesai" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($period['tanggal_selesai'] ?? 'now')) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                                <h5 class="fw-bold m-0 text-dark">Timeline Seleksi</h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-timeline-btn">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Tahap
                                </button>
                            </div>

                            <div id="timeline-container">
                                <?php
                                // Mengambil data timeline yang disimpan (format string dipisah |)
                                $savedTimeline = explode('|', $period['timeline'] ?? 'Pendaftaran Online');
                                foreach ($savedTimeline as $index => $step):
                                ?>
                                    <div class="timeline-item d-flex gap-2 mb-2">
                                        <span class="btn btn-light disabled fw-bold"><?= $index + 1 ?></span>
                                        <input type="text" class="form-control" name="timeline[]" value="<?= htmlspecialchars($step) ?>" required>
                                        <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-step"><i class="bi bi-trash"></i></button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Status & Visibilitas</h5>
                            <div class="mb-4">
                                <label class="form-label fw-bold small">Status Saat Ini</label>
                                <select name="status" class="form-select border-success fw-bold text-success">
                                    <option value="Draft" <?= ($period['status'] ?? '') == 'Draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="Active" <?= ($period['status'] ?? '') == 'Active' ? 'selected' : '' ?>>Active</option>
                                    <option value="Closed" <?= ($period['status'] ?? '') == 'Closed' ? 'selected' : '' ?>>Closed</option>
                                </select>
                                <p class="small text-muted mt-2">Dibuat: <?= date('d M Y', strtotime($period['created_at'] ?? 'now')) ?></p>
                            </div>
                        </div>

                        <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                            <h5 class="mb-4 fw-bold border-bottom pb-2 text-dark">Divisi Dibuka</h5>
                            <div class="division-grid" style="max-height: 200px; overflow-y: auto;">
                                <?php 
                                // Mengambil data divisi yang dibuka (format string dipisah koma)
                                $openedDivs = explode(', ', $period['opened_divisions'] ?? '');
                                if (empty($divisions)): 
                                ?>
                                    <p class="small text-muted">Belum ada data divisi.</p>
                                <?php else: foreach ($divisions as $index => $div): ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="divisions[]" 
                                               value="<?= htmlspecialchars($div['name']) ?>" 
                                               id="div_<?= $index ?>"
                                               <?= in_array($div['name'], $openedDivs) ? 'checked' : '' ?>>
                                        <label class="form-check-label small" for="div_<?= $index ?>">
                                            <?= htmlspecialchars($div['name']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">
                                <i class="bi bi-check-all me-2"></i>Simpan Perubahan
                            </button>
                            <a href="/admin/recruitment" class="btn btn-outline-secondary py-2 fw-semibold">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JS Tambah Step Timeline
        document.getElementById('add-timeline-btn').addEventListener('click', function() {
            const container = document.getElementById('timeline-container');
            const stepCount = container.children.length + 1;
            const div = document.createElement('div');
            div.className = 'timeline-item d-flex gap-2 mb-2';
            div.innerHTML = `
                <span class="btn btn-light disabled fw-bold">${stepCount}</span>
                <input type="text" class="form-control" name="timeline[]" placeholder="Tahap selanjutnya..." required>
                <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-step"><i class="bi bi-trash"></i></button>
            `;
            container.appendChild(div);
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-step')) {
                const item = e.target.closest('.timeline-item');
                if (document.querySelectorAll('.timeline-item').length > 1) {
                    item.remove();
                    document.querySelectorAll('.timeline-item').forEach((el, index) => {
                        el.querySelector('span').innerText = index + 1;
                    });
                }
            }
        });
    </script>
</body>
</html>