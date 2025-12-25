<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pemilihan - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    
    <link rel="stylesheet" href="/public/assets/css/admin/voting/create.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Form Pembuatan Pemilihan</h4>
                </div>
            </nav>

            <form id="electionForm">
                <div class="widget-card-admin">
                    <h5 class="mb-4 fw-bold text-primary-blue"><i class="bi bi-info-circle-fill me-2"></i>Detail Pemilihan</h5>
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label for="electionName" class="form-label">Nama Pemilihan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="electionName" placeholder="Contoh: Pemilihan Ketua Umum 2025/2026" required>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status Awal <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg" id="status" required>
                                <option value="Draft" selected>Draft (Belum Aktif)</option>
                                <option value="Active">Active (Langsung Mulai)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="electionDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="electionDescription" rows="3" placeholder="Berikan penjelasan singkat mengenai pemilihan ini..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="startDate" class="form-label">Tanggal & Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="startDate" required>
                        </div>
                        <div class="col-md-6">
                            <label for="endDate" class="form-label">Tanggal & Waktu Selesai <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="endDate" required>
                        </div>
                    </div>
                </div>

                <div class="widget-card-admin">
                    <h5 class="mb-4 fw-bold text-primary-blue"><i class="bi bi-person-check-fill me-2"></i>Eligible Voters (Pemilih Sah)</h5>
                    <div class="filter-section">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="allActiveMembers" checked>
                            <label class="form-check-label fw-bold" for="allActiveMembers">
                                Semua Anggota Aktif (Direkomendasikan)
                            </label>
                        </div>
                        <hr>
                        <label class="form-label d-block mb-3">Atau Filter Berdasarkan Generasi:</label>
                        <div class="row g-2" id="generasiFilterGroup">
                            <div class="col-6 col-md-3">
                                <div class="form-check p-2 border rounded bg-white">
                                    <input class="form-check-input ms-1" type="checkbox" value="17" id="gen17">
                                    <label class="form-check-label ms-2" for="gen17">Generasi 17</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-check p-2 border rounded bg-white">
                                    <input class="form-check-input ms-1" type="checkbox" value="16" id="gen16">
                                    <label class="form-check-label ms-2" for="gen16">Generasi 16</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-check p-2 border rounded bg-white">
                                    <input class="form-check-input ms-1" type="checkbox" value="15" id="gen15">
                                    <label class="form-check-label ms-2" for="gen15">Generasi 15</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-check p-2 border rounded bg-white">
                                    <input class="form-check-input ms-1" type="checkbox" value="15" id="gen15">
                                    <label class="form-check-label ms-2" for="gen15">Alumni</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-check p-2 border rounded bg-white">
                                    <input class="form-check-input ms-1" type="checkbox" value="15" id="gen15">
                                    <label class="form-check-label ms-2" for="gen15">Delegasi</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-card-admin">
                    <h5 class="mb-4 fw-bold text-primary-blue"><i class="bi bi-gear-fill me-2"></i>Pengaturan Tampilan</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="showRealtime" checked>
                                <label class="form-check-label fw-600" for="showRealtime">Tampilkan hasil real-time di Dashboard Admin</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="showAfterVote">
                                <label class="form-check-label fw-600" for="showAfterVote">Tampilkan hasil kepada pemilih setelah voting</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mb-5">
                    <button type="button" class="btn btn-light border px-4" onclick="history.back()">Batal</button>
                    <button type="submit" class="btn btn-orange px-5 shadow">Simpan Pemilihan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/voting/create.js"></script>
</body>
</html>