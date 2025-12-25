<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Management - EEPROM POLINEMA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="/public/assets/css/admin/voting/index.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="m-0 fw-bold">Voting Management</h4>
                </div>
                <button class="btn btn-orange rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#newElectionModal">
                    <i class="bi bi-plus-lg me-2"></i>Buat Pemilihan Baru
                </button>
            </nav>

            <div class="active-voting-banner">
                <div class="row align-items-center mb-4">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="status-badge bg-active"><i class="bi bi-record-fill me-1"></i>Voting Aktif</span>
                            <h4 class="m-0 text-primary-blue fw-bold">Pemilihan Ketua Umum 2026/2027</h4>
                        </div>
                        <p class="text-muted small mb-0"><i class="bi bi-calendar3 me-2"></i>Periode: 18 Des 2025 (08:00) s/d 19 Des 2025 (16:00)</p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <small class="text-danger fw-bold d-block mb-1">WAKTU TERSISA:</small>
                        <div class="countdown-display" id="countdownTimer">14:45:30</div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="stat-card-voting">
                            <h5>Total Pemilih</h5>
                            <div class="stat-value">150</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card-voting">
                            <h5>Sudah Memilih (Live)</h5>
                            <div class="stat-value" id="liveVotes">100</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card-voting">
                            <h5>Partisipasi</h5>
                            <div class="stat-value text-success" id="participationRate">74.0%</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card-voting">
                            <h5>Kandidat</h5>
                            <div class="stat-value">3</div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 align-items-center">
                    <div class="col-lg-8">
                        <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Hasil Sementara</h6>
                        <div class="p-3 bg-light rounded border">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1 small fw-bold">
                                    <span>Kandidat #01</span>
                                    <span>45% (83 Votes)</span>
                                </div>
                                <div class="progress" style="height: 12px;">
                                    <div class="progress-bar bg-primary" style="width: 45%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1 small fw-bold">
                                    <span>Kandidat #02</span>
                                    <span>30% (56 Votes)</span>
                                </div>
                                <div class="progress" style="height: 12px;">
                                    <div class="progress-bar bg-info" style="width: 30%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between mb-1 small fw-bold">
                                    <span>Kandidat #03</span>
                                    <span>25% (46 Votes)</span>
                                </div>
                                <div class="progress" style="height: 12px;">
                                    <div class="progress-bar bg-warning" style="width: 25%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex flex-column gap-2">
                        <a href="/src/Views/admin/voting/candidates.html" class="btn btn-outline-primary fw-bold">
                            <i class="bi bi-people me-2"></i>Kelola Kandidat
                        </a>
                        <button class="btn btn-outline-danger fw-bold">
                            <i class="bi bi-stop-circle me-2"></i>Tutup Voting Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-4"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Pemilihan</h5>
            <div class="row g-4">
                <div class="col-md-6 col-xl-4">
                    <div class="election-card p-4 h-100">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="status-badge bg-closed">Closed</span>
                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Pemilihan Ketua Umum 2024/2025</h6>
                        <p class="text-muted small mb-4">15 Des 2024 - 16 Des 2024</p>
                        <div class="row text-center g-0 border-top pt-3 mb-4">
                            <div class="col-6 border-end">
                                <div class="fw-bold">4</div>
                                <div class="small text-muted">Kandidat</div>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold">245</div>
                                <div class="small text-muted">Total Votes</div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-light border btn-sm fw-bold">
                                <i class="bi bi-trophy me-2 text-warning"></i>Lihat Hasil Akhir
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="election-card p-4 h-100" style="border-left: 5px solid #ffc107;">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="status-badge bg-draft">Draft</span>
                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Pemilihan Ketua Umum 2027/2028</h6>
                        <p class="text-muted small mb-4">Periode Belum Ditentukan</p>
                        <div class="row text-center g-0 border-top pt-3 mb-4">
                            <div class="col-6 border-end">
                                <div class="fw-bold">0</div>
                                <div class="small text-muted">Kandidat</div>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold">0</div>
                                <div class="small text-muted">Votes</div>
                            </div>
                        </div>
                        <div class="btn-group w-100">
                            <button class="btn btn-outline-secondary btn-sm">Edit</button>
                            <button class="btn btn-outline-danger btn-sm">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newElectionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white" style="background-color: var(--primary-blue) !important;">
                    <h5 class="modal-title fw-bold">Buat Sesi Pemilihan Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formNewElection">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pemilihan</label>
                            <input type="text" class="form-control" placeholder="Contoh: Pemilihan Ketua Umum 2026" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold">Mulai</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold">Selesai</label>
                                <input type="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold">Status Awal</label>
                            <select class="form-select">
                                <option value="draft">Simpan sebagai Draft</option>
                                <option value="active">Langsung Aktifkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-orange">Buat Pemilihan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>