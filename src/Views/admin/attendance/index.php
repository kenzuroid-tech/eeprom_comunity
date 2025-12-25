<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Attendance - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    
    <link rel="stylesheet" href="/public/assets/css/admin/attendance/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div id="mainContentWrapper" class="main-content-area">

            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="m-0 fw-bold">Input Absensi Rapat</h4>
                </div>
                
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin+EEPROM&background=1A237E&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
                        <span class="d-none d-sm-inline text-dark fw-bold">Super Admin</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="info-header shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <span class="badge bg-white text-primary mb-2">ID Rapat: #MTG-1218</span>
                        <h2 class="fw-bold mb-1">Rapat Koordinasi Diklat Lapang 2025</h2>
                        <p class="m-0 opacity-75"><i class="bi bi-calendar3 me-2"></i> Jumat, 19 Desember 2025 | <i class="bi bi-geo-alt me-2"></i> Basecamp Komunitas EEPROM</p>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs nav-tabs-custom" id="attendanceTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button"><i class="bi bi-pencil-square me-2"></i>Manual Input</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="qr-tab" data-bs-toggle="tab" data-bs-target="#qr" type="button"><i class="bi bi-qr-code-scan me-2"></i>Scan QR Code</button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="manual">
                    <div class="widget-card-admin">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                            <h5 class="fw-bold m-0 text-primary">Daftar Anggota Komunitas EEPROM</h5>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-success" id="btnHadirSemua">Set Hadir Semua</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="btnTidakSemua">Set Tidak Hadir Semua</button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Anggota</th>
                                        <th>NIM</th>
                                        <th>Gen</th>
                                        <th width="300">Status</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Siti+Nikmatus+Sholihah&background=random" class="avatar-img me-3">
                                                <span class="fw-bold">Siti Nikmatus Sholihah</span>
                                            </div>
                                        </td>
                                        <td>224107020014</td>
                                        <td>16</td>
                                        <td>
                                            <div class="btn-group w-100" role="group">
                                                <input type="radio" class="btn-check" name="att[1]" id="h1" checked>
                                                <label class="btn btn-outline-success btn-sm" for="h1">Hadir</label>
                                                <input type="radio" class="btn-check" name="att[1]" id="t1">
                                                <label class="btn btn-outline-danger btn-sm" for="t1">Tidak</label>
                                                <input type="radio" class="btn-check" name="att[1]" id="i1">
                                                <label class="btn btn-outline-warning btn-sm" for="i1">Izin</label>
                                            </div>
                                        </td>
                                        <td><input type="text" class="form-control form-control-sm" placeholder="Opsional"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Noirae+Lumiere&background=random" class="avatar-img me-3">
                                                <span class="fw-bold">Noirae Lumiere</span>
                                            </div>
                                        </td>
                                        <td>224107020015</td>
                                        <td>16</td>
                                        <td>
                                            <div class="btn-group w-100" role="group">
                                                <input type="radio" class="btn-check" name="att[2]" id="h2">
                                                <label class="btn btn-outline-success btn-sm" for="h2">Hadir</label>
                                                <input type="radio" class="btn-check" name="att[2]" id="t2" checked>
                                                <label class="btn btn-outline-danger btn-sm" for="t2">Tidak</label>
                                                <input type="radio" class="btn-check" name="att[2]" id="i2">
                                                <label class="btn btn-outline-warning btn-sm" for="i2">Izin</label>
                                            </div>
                                        </td>
                                        <td><input type="text" class="form-control form-control-sm" placeholder="Opsional"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-4">
                            <button class="btn btn-orange px-5 py-2 shadow-sm"><i class="bi bi-save me-2"></i>Simpan Absensi</button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="qr">
                    <div class="row g-4">
                        <div class="col-lg-5 text-center">
                            <div class="widget-card-admin h-100">
                                <h5 class="fw-bold mb-3">QR Code Meeting</h5>
                                <div class="qr-placeholder mb-4 shadow-sm">
                                    <i class="bi bi-qr-code text-dark" style="font-size: 150px;"></i>
                                </div>
                                <div class="alert alert-info py-2 small mb-4">
                                    <i class="bi bi-info-circle-fill me-2"></i>Anggota scan QR ini untuk absen otomatis
                                </div>
                                <p class="small text-muted mb-0">Meeting URL:</p>
                                <code class="d-block mb-3">eeprom.id/scan?mtg_id=1218&tk=sec_token</code>
                                <button class="btn btn-outline-primary btn-sm"><i class="bi bi-download me-2"></i>Unduh QR</button>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="widget-card-admin h-100">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold m-0"><i class="bi bi-broadcast text-danger me-2"></i>Real-time Attendance</h5>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success" id="statusRefresh">Auto-refresh: 5s</span>
                                        <button class="btn btn-sm btn-light border" id="btnRefreshManual"><i class="bi bi-arrow-clockwise"></i></button>
                                    </div>
                                </div>
                                <div class="list-group list-group-flush shadow-sm rounded border" id="scanList" style="max-height: 400px; overflow-y: auto;">
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-img bg-primary-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="bi bi-person text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Sapa aja</div>
                                                <small class="text-muted">NIM: 224107020100</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-light text-dark border fw-normal">19:12:45</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-img bg-primary-subtle d-flex align-items-center justify-content-center me-3">
                                                <i class="bi bi-person text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Memeng</div>
                                                <small class="text-muted">NIM: 224107020102</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-light text-dark border fw-normal">19:10:02</span>
                                    </div>
                                </div>
                                <div class="mt-3 text-center">
                                    <p class="small text-muted m-0">Total Terscan: 2 Anggota</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/attendance/index.js"></script>
    
</body>
</html>