<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwalkan Rapat - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/img/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/meetings/create.css">
    
</head>
<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold text-primary">Buat Jadwal Rapat</h4>
                </div>
            </nav>

            <div class="widget-card-admin">
                <form action="#" method="POST">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label">Judul Rapat</label>
                            <input type="text" class="form-control" placeholder="Contoh: Rapat Mingguan Divisi Software" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Deskripsi / Agenda</label>
                            <textarea class="form-control" rows="4" placeholder="Tuliskan detail pembahasan rapat..."></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Waktu</label>
                            <input type="time" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lokasi</label>
                            <input type="text" class="form-control" placeholder="Lab Robotika / Zoom" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Peserta Rapat</label>
                            <div class="participant-filter-box">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="allActive" checked>
                                    <label class="form-check-label fw-bold" for="allActive">Semua Anggota Aktif</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="small fw-bold text-muted mb-2 d-block">Filter Generasi</label>
                                        <select class="form-select" multiple style="height: 100px;">
                                            <option>Generasi 17</option>
                                            <option>Generasi 16</option>
                                            <option>Generasi 15</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="small fw-bold text-muted mb-2 d-block">Filter Divisi</label>
                                        <select class="form-select" multiple style="height: 100px;">
                                            <option>Software</option>
                                            <option>Mekanik</option>
                                            <option>Elektrik</option>
                                            <option>Humas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#selectMembers">Pilih Anggota Spesifik...</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check form-switch p-3 border rounded">
                                <input class="form-check-input ms-0 me-3" type="checkbox" id="generateQR" checked>
                                <label class="form-check-label fw-bold" for="generateQR">Generate QR Code untuk absensi otomatis?</label>
                            </div>
                        </div>

                        <div class="col-md-12 text-end mt-4">
                            <button type="button" class="btn btn-light me-2 border px-4">Cancel</button>
                            <button type="submit" class="btn btn-orange px-5 shadow-sm">Simpan Jadwal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <list src="/public/assets/js/admin/meetings/create.js"></list>

</body>
</html>