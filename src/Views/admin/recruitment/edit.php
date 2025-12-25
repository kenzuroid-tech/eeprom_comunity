<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recruitment - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/recruitment/edit.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="main-content-area">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold m-0 text-dark">Edit Recruitment</h4>
                    <small class="text-muted">ID: #REC-2024-001</small>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/admin/recruitment.php">Recruitment</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>

            <form action="update_process.php" method="POST">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="widget-card-admin">
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Detail Recruitment</h5>

                            <div class="mb-3">
                                <label class="form-label">Nama Periode Recruitment</label>
                                <input type="text" name="title" class="form-control" value="Open Recruitment Anggota Baru 2024" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Singkat</label>
                                <textarea name="description" class="form-control" rows="3">Membuka kesempatan bagi mahasiswa aktif Polinema untuk bergabung dalam pengembangan riset robotika.</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="datetime-local" name="start_date" class="form-control" value="2024-10-01T08:00" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="datetime-local" name="end_date" class="form-control" value="2024-10-31T23:59" required>
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label class="form-label">Persyaratan</label>
                                <div class="border rounded-3 p-3 bg-light">
                                    <textarea name="requirements" class="form-control" rows="8">1. Mahasiswa aktif tingkat 1 & 2.
2. Memiliki minat di bidang teknologi.
3. Berkomitmen mengikuti program pelatihan.
4. Mampu bekerja dalam tim.</textarea>
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
                                    <input type="text" class="form-control" name="timeline[]" value="Pendaftaran Online & Berkas">
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-step"><i class="bi bi-trash"></i></button>
                                </div>
                                <div class="timeline-item">
                                    <span class="fw-bold text-primary me-2">Step 2</span>
                                    <input type="text" class="form-control" name="timeline[]" value="Wawancara Internal">
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-step"><i class="bi bi-trash"></i></button>
                                </div>
                                <div class="timeline-item">
                                    <span class="fw-bold text-primary me-2">Step 3</span>
                                    <input type="text" class="form-control" name="timeline[]" value="Pengumuman Akhir">
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-step"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="widget-card-admin">
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Status & Visibilitas</h5>
                            <div class="mb-4">
                                <label class="form-label">Status Saat Ini</label>
                                <select name="status" class="form-select border-success fw-bold text-success">
                                    <option value="Draft">Draft</option>
                                    <option value="Active" selected>Active</option>
                                    <option value="Closed">Closed</option>
                                </select>
                                <p class="small text-muted mt-2">Terakhir diupdate: 15 Sep 2024</p>
                            </div>
                        </div>

                        <div class="widget-card-admin">
                            <h5 class="mb-4 fw-bold border-bottom pb-2">Divisi Dibuka</h5>
                            <div class="division-grid">
                                <?php
                                // Simulasi data checkbox dari DB
                                $divisions = [
                                    'div1' => ['label' => 'Mekanik', 'checked' => 'checked'],
                                    'div2' => ['label' => 'Software', 'checked' => 'checked'],
                                    'div3' => ['label' => 'Elektrik', 'checked' => 'checked'],
                                    'div4' => ['label' => 'Humas', 'checked' => ''],
                                    'div5' => ['label' => 'Media', 'checked' => ''],
                                ];
                                foreach ($divisions as $id => $data):
                                ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="divisions[]" id="<?= $id ?>" value="<?= $data['label'] ?>" <?= $data['checked'] ?>>
                                        <label class="form-check-label small" for="<?= $id ?>"><?= $data['label'] ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn custom-btn-update">
                                <i class="bi bi-check-all me-2"></i>Simpan Perubahan
                            </button>
                            <a href="/admin/recruitment.php" class="btn btn-outline-secondary py-2 fw-semibold">Batal</a>
                        </div>
                        <div class="mt-4 p-3 bg-white border-start border-danger border-4 rounded shadow-sm">
                            <h6 class="text-danger fw-bold small"><i class="bi bi-info-circle me-1"></i> Zona Bahaya</h6>
                            <p style="font-size: 11px;" class="m-0">Menutup pendaftaran akan menghentikan seluruh proses aplikasi yang sedang berjalan.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/recruitment/edit.js"></script>
</body>

</html>