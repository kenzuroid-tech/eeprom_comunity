<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemilihan - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    
    <link rel="stylesheet" href="/public/assets/css/admin/voting/result.css">

</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <a href="/src/Views/admin/voting/" class="btn btn-sm btn-light border me-3"><i class="bi bi-arrow-left"></i></a>
                    <h4 class="m-0 fw-bold">Voting Results</h4>
                </div>
                
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel me-1"></i> Excel</button>
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf me-1"></i> PDF</button>
                </div>
            </nav>

            <div class="election-banner shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <span class="badge bg-white text-primary mb-2">ID: #VOT-2024-001</span>
                        <h2 class="fw-bold m-0">Pemilihan Ketua Umum EEPROM 2025/2026</h2>
                        <p class="m-0 opacity-75 small mt-1"><i class="bi bi-calendar-event me-2"></i>Selesai pada: 15 Desember 2024, 16:00 WIB</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <span class="badge bg-dark px-3 py-2 fs-6 rounded-pill"><i class="bi bi-lock-fill me-2"></i>CLOSED</span>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stat-card-admin">
                        <h6 class="text-muted small fw-bold">Eligible Voters</h6>
                        <h3 class="fw-bold m-0 text-primary">150</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin" style="border-left-color: #28a745;">
                        <h6 class="text-muted small fw-bold">Total Votes</h6>
                        <h3 class="fw-bold m-0 text-success">140</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin" style="border-left-color: var(--accent-orange);">
                        <h6 class="text-muted small fw-bold">Partisipasi</h6>
                        <h3 class="fw-bold m-0 text-orange" style="color: var(--accent-orange);">94.0%</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin" style="border-left-color: #6c757d;">
                        <h6 class="text-muted small fw-bold">Abstain</h6>
                        <h3 class="fw-bold m-0 text-secondary">10</h3>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="widget-card-admin h-100">
                        <h5 class="fw-bold mb-4"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Visualisasi Perolehan Suara</h5>
                        
                        <div class="mb-4">
                            <div class="progress-label">
                                <span>#01 - Kandidat 1</span>
                                <span>70 Votes (51.1%)</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 51.1%"></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="progress-label">
                                <span>#02 - Kandidat 2</span>
                                <span> 47Votes (36.2%)</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 36.2%"></div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="progress-label">
                                <span>#03 - Kandidat 3</span>
                                <span>23 Votes (12.7%)</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 12.7%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="winner-box h-100 shadow-sm d-flex flex-column align-items-center justify-content-center">
                        <i class="bi bi-trophy-fill text-warning fs-1 mb-2"></i>
                        <img src="https://ui-avatars.com/api/?name=Kandidat+1&background=1A237E&color=fff" class="winner-photo" alt="Winner">
                        <h4 class="fw-bold mb-1">Kandidat 1</h4>
                        <p class="text-muted m-0">70 Suara (51.1%)</p>
                        <div class="terpilih-badge">TERPILIH</div>
                        <p class="small mt-3 text-muted">Ketua Umum EEPROM 2025/2026</p>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0"><i class="bi bi-shield-check me-2 text-primary"></i>Audit Log Kehadiran Pemilih</h5>
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari pemilih...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Pemilih</th>
                                <th>NIM</th>
                                <th>Gen</th>
                                <th>Pilihan (Audit)</th>
                                <th>Waktu Vote</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            <tr>
                                <td class="fw-bold">Budi Santoso</td>
                                <td>2241720081</td>
                                <td>17</td>
                                <td><span class="badge bg-light text-dark border">Kandidat #01</span></td>
                                <td>15 Des, 09:12:45</td>
                                <td><code>192.168.1.45</code></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Rina Maharani</td>
                                <td>2141720022</td>
                                <td>16</td>
                                <td><span class="badge bg-light text-dark border">Kandidat #02</span></td>
                                <td>15 Des, 10:05:12</td>
                                <td><code>114.124.2.11</code></td>
                            </tr>
                            </tbody>
                    </table>
                </div>
                <nav class="mt-4">
                    <ul class="pagination pagination-sm justify-content-end m-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/voting/result.js"></script>
</body>
</html>