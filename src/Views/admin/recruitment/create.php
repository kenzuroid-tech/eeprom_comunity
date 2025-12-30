<?php
$adminData = $adminData ?? [];
$divisions = $divisions ?? []; // Diambil dari database via Controller
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Recruitment - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin/recruitment/create.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0 text-dark">Buat Recruitment Baru</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/admin/recruitment">Recruitment</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>

            <form action="/admin/recruitment/store" method="POST">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Informasi Dasar</h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nama Periode Recruitment</label>
                                <input type="text" name="nama_periode" class="form-control" placeholder="Contoh: Open Recruitment Anggota Baru 2024" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Deskripsi Singkat</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan tujuan recruitment ini..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Tanggal Mulai</label>
                                    <input type="datetime-local" name="tanggal_mulai" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Tanggal Selesai</label>
                                    <input type="datetime-local" name="tanggal_selesai" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Semester</label>
                                <select name="semester" class="form-select">
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Tahun Akademik</label>
                                <input type="text" name="tahun_akademik" class="form-control" placeholder="2024/2025">
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
                                <div class="timeline-input-item d-flex gap-2 mb-2">
                                    <span class="btn btn-light disabled fw-bold">1</span>
                                    <input type="text" class="form-control" name="timeline[]" placeholder="Contoh: Pendaftaran Online" required>
                                    <button type="button" class="btn btn-outline-danger remove-step"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">*Urutan tahapan akan disesuaikan secara otomatis.</small>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Pengaturan Status</h5>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Status Saat Ini</label>
                                <select name="status" class="form-select border-primary fw-bold text-primary">
                                    <option value="Draft">Draft</option>
                                    <option value="Active">Active</option>
                                    <option value="Closed">Closed</option>
                                </select>
                                <div class="alert alert-warning mt-3 small p-2" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Sistem akan otomatis menutup periode lainnya jika Anda memilih <strong>Active</strong>.
                                </div>
                            </div>
                        </div>

                        <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                            <h5 class="mb-4 fw-bold border-bottom pb-2 text-dark">Divisi Dibuka</h5>
                            <div class="division-grid" style="max-height: 200px; overflow-y: auto;">
                                <?php if (empty($divisions)): ?>
                                    <p class="small text-muted">Belum ada data divisi.</p>
                                    <?php else: foreach ($divisions as $index => $div): ?>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="divisions[]" value="<?= $div['name'] ?>" id="div<?= $index ?>">
                                            <label class="form-check-label small" for="div<?= $index ?>"><?= htmlspecialchars($div['name']) ?></label>
                                        </div>
                                <?php endforeach;
                                endif; ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i>Simpan Recruitment
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
        // JS Sederhana untuk Tambah/Hapus Step Timeline
        document.getElementById('add-timeline-btn').addEventListener('click', function() {
            const container = document.getElementById('timeline-container');
            const stepCount = container.children.length + 1;
            const div = document.createElement('div');
            div.className = 'timeline-input-item d-flex gap-2 mb-2';
            div.innerHTML = `
                <span class="btn btn-light disabled fw-bold">${stepCount}</span>
                <input type="text" class="form-control" name="timeline[]" placeholder="Tahap selanjutnya..." required>
                <button type="button" class="btn btn-outline-danger remove-step"><i class="bi bi-trash"></i></button>
            `;
            container.appendChild(div);
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-step')) {
                const item = e.target.closest('.timeline-input-item');
                if (document.querySelectorAll('.timeline-input-item').length > 1) {
                    item.remove();
                    // Update nomor urut
                    document.querySelectorAll('.timeline-input-item').forEach((el, index) => {
                        el.querySelector('span').innerText = index + 1;
                    });
                }
            }
        });
    </script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>