<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/member-area/voting/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../../layouts/sidebar-ma.php'; ?>
        
        <div id="mainContentWrapper" class="main-content-area">

            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="m-0 fw-bold">Pemilihan Ketua Umum 2026</h4>
                </div>
                <div class="d-flex align-items-center">
                    <span class="timer-box d-none d-md-block" id="topTimer">00 : 00 : 00</span>
                </div>
            </nav>

            <div class="mb-4 d-flex gap-2 flex-wrap">
                <button class="btn btn-sm btn-outline-secondary" onclick="switchMode('upcoming')">Mode: Belum Buka</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="switchMode('active')">Mode: Aktif (Belum Vote)</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="switchMode('voted')">Mode: Sudah Vote</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="switchMode('closed')">Mode: Selesai</button>
            </div>

            <div id="section-upcoming" class="voting-section d-none text-center py-5">
                <div class="info-box-custom info-upcoming mx-auto" style="max-width: 600px;">
                    <i class="bi bi-calendar-event fs-1 mb-3"></i>
                    <h4>Voting Belum Dibuka</h4>
                    <p>Voting Pemilihan Ketua Umum EEPROM 2026 akan dibuka pada tanggal <strong>1 Januari 2026</strong>.</p>
                    <div class="timer-box fs-3 mt-3">05 Hari : 12 Jam : 30 Menit</div>
                </div>
            </div>

            <div id="section-active" class="voting-section d-none">
                <div class="info-box-custom info-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Penting:</strong> Anda hanya memiliki satu kali kesempatan memilih. Pilihan yang sudah dikirim tidak dapat diubah kembali!
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6 col-lg-4">
                        <div class="candidate-card">
                            <img src="https://ui-avatars.com/api/?name=Kandidat+01&size=250&background=1A237E&color=fff" class="candidate-img" alt="Kandidat 01">
                            <div class="candidate-body">
                                <span class="badge bg-primary mb-2">No. Urut 01</span>
                                <h5 class="fw-bold text-dark">Ahmad Fauzi</h5>
                                <div class="candidate-info mb-3">
                                    <p class="text-muted"><i class="bi bi-card-text me-2"></i>2241720001</p>
                                    <p class="text-muted"><i class="bi bi-layers me-2"></i>Generasi 15 (Software)</p>
                                </div>
                                
                                <div class="accordion mb-4" id="visimisi1">
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed rounded bg-light small fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#desc1">
                                                Lihat Visi Misi
                                            </button>
                                        </h2>
                                        <div id="desc1" class="accordion-collapse collapse" data-bs-parent="#visimisi1">
                                            <div class="accordion-body small">
                                                <strong>Visi:</strong> Mewujudkan EEPROM sebagai kiblat robotika yang inovatif. <br><br>
                                                <strong>Misi:</strong>
                                                <ul class="ps-3 mt-1">
                                                    <li>Mengadakan workshop berkala.</li>
                                                    <li>Meningkatkan prestasi nasional.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="radio" name="candidate" id="vote1" class="vote-check">
                                <label for="vote1" class="vote-label">Pilih Kandidat Ini</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="candidate-card">
                            <img src="https://ui-avatars.com/api/?name=Kandidat+02&size=250&background=FF5722&color=fff" class="candidate-img" alt="Kandidat 02">
                            <div class="candidate-body">
                                <span class="badge bg-primary mb-2">No. Urut 02</span>
                                <h5 class="fw-bold text-dark">Siti Aminah</h5>
                                <div class="candidate-info mb-3">
                                    <p class="text-muted"><i class="bi bi-card-text me-2"></i>2241720055</p>
                                    <p class="text-muted"><i class="bi bi-layers me-2"></i>Generasi 15 (Elektrik)</p>
                                </div>
                                
                                <div class="accordion mb-4" id="visimisi2">
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed rounded bg-light small fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#desc2">
                                                Lihat Visi Misi
                                            </button>
                                        </h2>
                                        <div id="desc2" class="accordion-collapse collapse" data-bs-parent="#visimisi2">
                                            <div class="accordion-body small">
                                                <strong>Visi:</strong> EEPROM Harmonis dan Berprestasi.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="radio" name="candidate" id="vote2" class="vote-check">
                                <label for="vote2" class="vote-label">Pilih Kandidat Ini</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center pb-5">
                    <button class="btn btn-submit-vote" onclick="confirmVote()">
                        <i class="bi bi-send-fill me-2"></i> Submit Vote Saya
                    </button>
                </div>
            </div>

            <div id="section-voted" class="voting-section d-none">
                <div class="info-box-custom info-success text-center py-5">
                    <i class="bi bi-check-circle-fill fs-1 mb-3"></i>
                    <h3>Terima Kasih Sudah Memilih!</h3>
                    <p class="mb-4">Partisipasi Anda sangat berarti untuk masa depan EEPROM Polinema.</p>
                    <div class="bg-white p-4 rounded-4 shadow-sm d-inline-block text-start border">
                        <p class="mb-1 small text-muted">Anda Telah Memilih:</p>
                        <h5 class="fw-bold text-dark">Ahmad Fauzi (No. Urut 01)</h5>
                        <p class="small text-muted m-0">Pada: 20 Desember 2025, 22:45 WIB</p>
                    </div>
                </div>
            </div>

            <div id="section-closed" class="voting-section d-none">
                <div class="info-box-custom info-closed mb-4">
                    <i class="bi bi-lock-fill me-2"></i> Voting telah ditutup pada 15 Januari 2026.
                </div>

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="widget-card-admin bg-white p-4 rounded-4 shadow-sm h-100">
                            <h5 class="fw-bold mb-4">Hasil Perolehan Suara</h5>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span>Ahmad Fauzi</span>
                                    <span>65% (162 Votes)</span>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar" style="width: 65%; background: var(--primary-blue);"></div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span>Siti Aminah</span>
                                    <span>35% (88 Votes)</span>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar" style="width: 35%; background: var(--accent-orange);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="candidate-card bg-white text-center p-4">
                            <h6 class="fw-bold text-muted mb-3">KETUA UMUM TERPILIH</h6>
                            <img src="https://ui-avatars.com/api/?name=Ahmad+Fauzi&size=150&background=28a745&color=fff" class="rounded-circle mb-3 border border-4 border-success p-1" width="150" alt="Pemenang">
                            <h4 class="fw-bold mb-0">Ahmad Fauzi</h4>
                            <span class="badge bg-success px-4 py-2 mt-2">Terpilih sebagai Ketua Umum 2026</span>
                            <hr>
                            <div class="row text-center">
                                <div class="col-6 border-end">
                                    <p class="small text-muted mb-0">Total Suara</p>
                                    <h5 class="fw-bold mb-0">162</h5>
                                </div>
                                <div class="col-6">
                                    <p class="small text-muted mb-0">Persentase</p>
                                    <h5 class="fw-bold mb-0">65%</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 20px;">
                <div class="modal-body text-center p-4">
                    <i class="bi bi-question-circle text-warning fs-1"></i>
                    <h4 class="fw-bold mt-3">Konfirmasi Pilihan</h4>
                    <p>Apakah Anda yakin ingin memilih kandidat ini? Pilihan Anda tidak dapat diubah setelah Anda klik 'Konfirmasi'.</p>
                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <button class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary px-4" onclick="submitVote()" style="background: var(--primary-blue);">Ya, Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/member-area/voting/index.js"></script>
</body>
</html>