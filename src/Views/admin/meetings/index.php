<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting & Attendance - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="/public/assets/css/admin/meetings/index.css">
    <link rel="icon" href="/img/eeprom logo.png" type="image/png">
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
                    <h4 class="m-0 fw-bold">Meetings & Attendance</h4>
                </div>
                
                <div class="d-flex align-items-center">
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
                </div>
            </nav>

            <div class="widget-card-admin">
                <ul class="nav nav-tabs nav-tabs-custom mb-4" id="meetingTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button">Upcoming Meetings</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button">Past Meetings</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button">Attendance Reports</button>
                    </li>
                </ul>

                <div class="tab-content" id="meetingTabsContent">
                    
                    <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold mb-0">Rapat Terjadwal</h6>
                            <button class="btn btn-orange btn-sm shadow-sm"><i class="bi bi-calendar-plus me-2"></i>Jadwalkan Rapat Baru</button>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-4">
                                <div class="meeting-card p-4 border">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="badge bg-primary-subtle text-primary rounded-pill">Koordinasi</span>
                                        <i class="bi bi-three-dots-vertical text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold mb-3">Rapat Mingguan Divisi Software</h5>
                                    <ul class="list-unstyled small text-muted mb-4">
                                        <li class="mb-2"><i class="bi bi-calendar-event me-2"></i>Kamis, 19 Des 2024</li>
                                        <li class="mb-2"><i class="bi bi-clock me-2"></i>19.00 - 21.00 WIB</li>
                                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>Lab Robotika / Online</li>
                                        <li><i class="bi bi-people me-2"></i>45 Anggota Terdaftar</li>
                                    </ul>
                                    <div class="d-grid gap-2">
                                        <a href="#" class="btn btn-primary btn-sm"><i class="bi bi-qr-code-scan me-2"></i>Input Attendance</a>
                                        <div class="btn-group">
                                            <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil me-1"></i> Edit</button>
                                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="past" role="tabpanel">
                        <div class="row mb-4 align-items-end g-3">
                            <div class="col-md-4">
                                <label class="small fw-bold mb-2">Filter Rentang Tanggal</label>
                                <div class="input-group input-group-sm">
                                    <input type="date" class="form-control">
                                    <span class="input-group-text">to</span>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul Rapat</th>
                                        <th>Tanggal</th>
                                        <th>Kehadiran</th>
                                        <th>Persentase</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <tr>
                                        <td class="fw-bold">Evaluasi Lomba KRI</td>
                                        <td>10 Des 2024</td>
                                        <td>42/45</td>
                                        <td><span class="badge bg-success">93.3%</span></td>
                                        <td>
                                            <button class="btn btn-light btn-sm border"><i class="bi bi-eye"></i> View</button>
                                            <button class="btn btn-light btn-sm border"><i class="bi bi-pencil"></i> Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="reports" role="tabpanel">
                        <div class="row mb-5 g-4">
                            <div class="col-lg-4">
                                <label class="small fw-bold mb-2">Pilih Anggota</label>
                                <select class="form-select mb-4 shadow-sm">
                                    <option selected disabled>Cari Nama / NIM...</option>
                                    <option>Ahmad Fauzan (2241720XXX)</option>
                                    <option>Budi Santoso (2241720XXX)</option>
                                </select>
                                <button class="btn btn-orange w-100 shadow-sm"><i class="bi bi-file-earmark-arrow-down me-2"></i>Export Report (PDF/Excel)</button>
                            </div>
                            <div class="col-lg-8">
                                <div class="row text-center g-3">
                                    <div class="col-4">
                                        <div class="stat-circle" style="color: var(--primary-blue);">15</div>
                                        <p class="small text-muted fw-bold">Total Rapat</p>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-circle text-success">13</div>
                                        <p class="small text-muted fw-bold">Total Hadir</p>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-circle text-primary">86%</div>
                                        <p class="small text-muted fw-bold">Persentase</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Kehadiran</h6>
                        <div class="table-responsive">
                            <table class="table table-hover border-top">
                                <thead class="small fw-bold">
                                    <tr>
                                        <th>Pertemuan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <tr>
                                        <td>Rapat Mingguan Divisi Software</td>
                                        <td>12 Des 2024</td>
                                        <td><span class="text-success fw-bold">HADIR</span></td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Briefing Kunjungan Industri</td>
                                        <td>05 Des 2024</td>
                                        <td><span class="text-danger fw-bold">ABSEN</span></td>
                                        <td>Sakit (Surat terlampir)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/meetings/index.js"></script>
</body>
</html>