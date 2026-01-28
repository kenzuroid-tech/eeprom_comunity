<?php
/**
 * File: src/Views/admin/meetings/create.php
 */
$adminData = $adminData ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwalkan Rapat - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/meetings/create.css">
    <style>
        .widget-card-admin { background: #fff; padding: 2rem; border-radius: 15px; shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .btn-orange { background-color: #ff6b00; color: white; border: none; }
        .btn-orange:hover { background-color: #e66000; color: white; }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold text-primary">Buat Jadwal Rapat</h4>
                </div>
            </nav>

            <div class="widget-card-admin shadow-sm">
                <form action="/admin/meetings/store" method="POST">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Judul Rapat</label>
                            <input type="text" name="title" class="form-control" placeholder="Contoh: Rapat Mingguan Divisi Software" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Deskripsi / Agenda</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Tuliskan detail pembahasan rapat..."></textarea>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tanggal</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Waktu Mulai</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Lokasi</label>
                            <input type="text" name="location" class="form-control" placeholder="Lab Robotika / Zoom" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Peserta Rapat</label>
                            <div class="participant-filter-box p-3 border rounded bg-light">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="allActive" name="target_all" value="1" checked>
                                    <label class="form-check-label fw-bold" for="allActive">Semua Anggota Aktif</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="small fw-bold text-muted mb-2 d-block">Filter Generasi</label>
                                        <select name="filter_gen[]" class="form-select" multiple style="height: 100px;">
                                            <option value="17">Generasi 17</option>
                                            <option value="16">Generasi 16</option>
                                            <option value="15">Generasi 15</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="small fw-bold text-muted mb-2 d-block">Filter Divisi</label>
                                        <select name="filter_div[]" class="form-select" multiple style="height: 100px;">
                                            <option value="Software">Software</option>
                                            <option value="Mekanik">Mekanik</option>
                                            <option value="Elektrik">Elektrik</option>
                                            <option value="Humas">Humas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check form-switch p-3 border rounded bg-white">
                                <input class="form-check-input ms-0 me-3" type="checkbox" name="use_qr" id="generateQR" value="1" checked>
                                <label class="form-check-label fw-bold" for="generateQR">Generate QR Code untuk absensi otomatis?</label>
                            </div>
                        </div>

                        <div class="col-md-12 text-end mt-4">
                            <a href="/admin/meetings" class="btn btn-light me-2 border px-4">Cancel</a>
                            <button type="submit" class="btn btn-orange px-5 shadow-sm fw-bold">
                                <i class="bi bi-calendar-check me-2"></i>Simpan Jadwal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Logika sederhana untuk menonaktifkan filter jika "Semua Anggota" dicentang
        const allActiveCheck = document.getElementById('allActive');
        const filters = document.querySelectorAll('select[multiple]');
        
        allActiveCheck.addEventListener('change', function() {
            filters.forEach(f => f.disabled = this.checked);
        });
    </script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>
</html>