<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pemilihan - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/voting/create.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Form Pembuatan Pemilihan</h4>
                </div>
            </nav>

            <form action="/admin/voting/store-election" method="POST">
                <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="mb-4 fw-bold text-primary-blue"><i class="bi bi-info-circle-fill me-2"></i>Detail Pemilihan</h5>
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Nama Pemilihan <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg" placeholder="Contoh: Pemilihan Ketua Umum 2025/2026" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Status Awal <span class="text-danger">*</span></label>
                            <select name="status" class="form-select form-select-lg" required>
                                <option value="Draft" selected>Draft (Belum Aktif)</option>
                                <option value="Active">Active (Langsung Mulai)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Berikan penjelasan singkat mengenai pemilihan ini..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal & Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal & Waktu Selesai <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="mb-4 fw-bold text-primary-blue"><i class="bi bi-person-check-fill me-2"></i>Eligible Voters (Pemilih Sah)</h5>
                    <div class="filter-section">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="allow_all" id="allActiveMembers" value="1" checked>
                            <label class="form-check-label fw-bold" for="allActiveMembers">Semua Anggota Aktif (Direkomendasikan)</label>
                        </div>

                        <div class="row mb-3 g-2">
                            <div class="col-md-6">
                                <div class="form-check p-2 border rounded shadow-sm bg-white">
                                    <input class="form-check-input ms-1" type="checkbox" name="allow_alumni" id="allowAlumni" value="1">
                                    <label class="form-check-label ms-2 fw-semibold text-secondary" for="allowAlumni">
                                        <i class="bi bi-mortarboard-fill me-1 text-danger"></i> Sertakan Alumni
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check p-2 border rounded shadow-sm bg-white">
                                    <input class="form-check-input ms-1" type="checkbox" name="allow_delegasi" id="allowDelegasi" value="1">
                                    <label class="form-check-label ms-2 fw-semibold text-secondary" for="allowDelegasi">
                                        <i class="bi bi-person-workspace me-1 text-primary"></i> Sertakan Delegasi Luar
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <label class="form-label d-block mb-3">Atau Filter Spesifik Berdasarkan Generasi:</label>
                        <div class="row g-2" id="generasiFilterGroup">
                            <?php for ($i = 15; $i <= 17; $i++): ?>
                                <div class="col-6 col-md-3">
                                    <div class="form-check p-2 border rounded bg-light">
                                        <input class="form-check-input ms-1" type="checkbox" name="generations[]" value="<?= $i ?>" id="gen<?= $i ?>">
                                        <label class="form-check-label ms-2" for="gen<?= $i ?>">Generasi <?= $i ?></label>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>

                <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="mb-4 fw-bold text-primary-blue"><i class="bi bi-gear-fill me-2"></i>Pengaturan Tampilan</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input ms-0 me-3" type="checkbox" name="show_realtime" value="1" id="showRealtime" checked>
                                <label class="form-check-label fw-bold" for="showRealtime">Tampilkan hasil real-time di Admin</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input ms-0 me-3" type="checkbox" name="show_after" value="1" id="showAfterVote">
                                <label class="form-check-label fw-bold" for="showAfterVote">Tampilkan hasil ke pemilih selesai voting</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mb-5">
                    <button type="button" class="btn btn-light border px-4" onclick="history.back()">Batal</button>
                    <button type="submit" class="btn btn-primary px-5 shadow fw-bold">Simpan Pemilihan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle disable generasi jika "Semua Anggota" dicentang
        const allActive = document.getElementById('allActiveMembers');
        const genChecks = document.querySelectorAll('input[name="generations[]"]');

        allActive.addEventListener('change', function() {
            genChecks.forEach(cb => cb.disabled = this.checked);
        });
    </script>
    <script src="/assets/js/admin/dashboard.js"></script>

</body>

</html>