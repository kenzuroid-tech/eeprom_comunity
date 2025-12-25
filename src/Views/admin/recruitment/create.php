<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Recruitment - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/recruitment/create.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="main-content-area">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0 text-dark">Buat Recruitment Baru</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/admin/recruitment.php">Recruitment</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>

            <form action="process.php" method="POST">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="widget-card-admin">
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Informasi Dasar</h5>

                            <div class="mb-3">
                                <label class="form-label">Nama Periode Recruitment</label>
                                <input type="text" name="recruitment_name" class="form-control" placeholder="Contoh: Open Recruitment Anggota Baru 2024" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Singkat</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan tujuan recruitment ini..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="datetime-local" name="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="datetime-local" name="end_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label class="form-label">Persyaratan</label>
                                <div class="border rounded-3 p-3 bg-light" style="min-height: 150px;">
                                    <textarea name="requirements" class="form-control" rows="5" placeholder="Tulis list persyaratan di sini..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="widget-card-admin">
                            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                                <h5 class="fw-bold m-0">Timeline Seleksi</h5>
                                <a href="javascript:void(0)" class="btn-add-step" id="add-timeline-btn">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Tahap
                                </a>
                            </div>

                            <div id="timeline-container">
                                <div class="timeline-item">
                                    <span class="fw-bold text-primary me-2">Step 1</span>
                                    <input type="text" class="form-control" name="timeline[]" placeholder="Contoh: Pendaftaran Online">
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-step"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">*Urutan tahapan akan disesuaikan secara otomatis.</small>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="widget-card-admin">
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Pengaturan Status</h5>
                            <div class="mb-4">
                                <label class="form-label">Status Saat Ini</label>
                                <select name="status" class="form-select border-primary fw-bold text-primary">
                                    <option value="Draft">Draft</option>
                                    <option value="Active">Active</option>
                                    <option value="Closed">Closed</option>
                                </select>
                                <div class="alert alert-warning mt-3 small p-2" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Hanya boleh ada <strong>1 recruitment</strong> dengan status "Active".
                                </div>
                            </div>
                        </div>

                        <div class="widget-card-admin">
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Divisi Dibuka</h5>
                            <div class="division-grid">
                                <?php
                                // Contoh array divisi (Bisa diambil dari Database)
                                $divisions = ['Mekanik', 'Software', 'Elektrik', 'Humas', 'Media'];
                                foreach ($divisions as $index => $div):
                                ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="divisions[]" value="<?= $div ?>" id="div<?= $index ?>">
                                        <label class="form-check-label small" for="div<?= $index ?>"><?= $div ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary custom-btn-save">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i>Simpan Recruitment
                            </button>
                            <a href="/admin/recruitment.php" class="btn btn-outline-secondary py-2 fw-semibold">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/recruitment/create.js"></script>
</body>

</html>