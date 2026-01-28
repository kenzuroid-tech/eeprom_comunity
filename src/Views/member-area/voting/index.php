<?php
$userData = $userData ?? [];
$candidates = $candidates ?? [];
$userVote = $userVote ?? null;
$stats = $stats ?? [];
$election = $election ?? null;
$accessCode = $accessCode ?? null;
$noElection = $noElection ?? false;

// Cek apakah kode sudah diverifikasi
$codeVerified = isset($_SESSION['voting_code_id']);

$totalAllVotes = array_sum(array_column($stats, 'total_votes'));
$fotoPath = !empty($userData['foto_url']) ? $userData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($userData['nama_lengkap'] ?? 'User');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/member-area/voting/index.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light border me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h5 class="m-0 fw-bold text-dark"><?= $election ? htmlspecialchars($election['title']) : 'E-Voting' ?></h5>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 gap-md-3">
                    <?php if ($codeVerified): ?>
                        <span class="badge bg-success-subtle text-success px-3 py-2">
                            <i class="bi bi-shield-check me-1"></i> Kode Terverifikasi
                        </span>
                    <?php endif; ?>

                    <div class="vr d-none d-sm-block mx-1" style="height: 30px;"></div>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle p-1 rounded-pill hover-bg-light" data-bs-toggle="dropdown">
                            <img src="<?= htmlspecialchars($fotoPath) ?>" alt="Profile" width="35" height="35" class="rounded-circle border" style="object-fit: cover;">
                            <span class="d-none d-sm-inline text-dark fw-bold small ms-2 me-1">
                                <?= htmlspecialchars($userData['nama_lengkap'] ?? 'Member') ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                            <li><a class="dropdown-item py-2" href="/member/profile"><i class="bi bi-person me-2 text-primary"></i>Profile Saya</a></li>
                            <li><a class="dropdown-item py-2" href="/member/dashboard"><i class="bi bi-speedometer2 me-2 text-secondary"></i>Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php if ($noElection): ?>
                <!-- Tidak Ada Pemilihan Aktif -->
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                    <h4 class="fw-bold">Tidak Ada Pemilihan Aktif</h4>
                    <p class="text-muted">Saat ini belum ada sesi pemilihan yang sedang berlangsung.</p>
                </div>

            <?php elseif ($userVote): ?>
                <!-- Sudah Vote -->
                <div id="section-voted" class="voting-section text-center py-5 bg-white rounded-4 shadow-sm">
                    <i class="bi bi-check-circle-fill fs-1 text-success mb-3"></i>
                    <h3 class="fw-bold">Terima Kasih Sudah Memilih!</h3>
                    <p class="mb-4">Partisipasi Anda sangat berarti untuk masa depan EEPROM Polinema.</p>
                    <div class="bg-light p-4 rounded-4 d-inline-block text-start border">
                        <p class="mb-1 small text-muted">Anda Telah Memilih:</p>
                        <h5 class="fw-bold text-dark"><?= $userVote['candidate_name'] ?> (No. Urut <?= $userVote['number_order'] ?>)</h5>
                        <p class="small text-muted m-0">Pada: <?= date('d M Y, H:i', strtotime($userVote['voted_at'])) ?> WIB</p>
                    </div>
                </div>

            <?php elseif (!$codeVerified): ?>
                <!-- Belum Input Kode -->
                <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                    <i class="bi bi-key-fill fs-1 text-primary mb-3 d-block"></i>
                    <h4 class="fw-bold">Kode Akses Diperlukan</h4>
                    <p class="text-muted mb-4">Anda perlu memasukkan kode akses unik untuk mengikuti pemilihan ini.</p>
                    
                    <?php if ($accessCode): ?>
                        <div class="alert alert-info d-inline-block mb-4 px-5 py-3">
                            <p class="mb-2 text-muted small">📋 Kode Akses Anda:</p>
                            <h3 class="fw-bold m-0 text-primary" style="letter-spacing: 2px; font-family: 'Courier New', monospace;">
                                <?= htmlspecialchars($accessCode['code']) ?>
                            </h3>
                        </div>
                        <p class="text-muted small mb-4">
                            <i class="bi bi-info-circle me-1"></i>
                            Simpan kode ini dengan baik. Klik tombol di bawah untuk melanjutkan.
                        </p>
                    <?php else: ?>
                        <div class="alert alert-warning d-inline-block mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Anda belum memiliki kode akses. Hubungi admin untuk mendapatkan kode.
                        </div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="/member/voting/enter-code" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Masukkan Kode Akses
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <!-- Form Voting -->
                <div id="section-active" class="voting-section">
                    <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Penting:</strong> Anda hanya memiliki satu kali kesempatan memilih. Pilihan tidak dapat diubah kembali!
                    </div>

                    <form action="/member/voting/submit" method="POST" id="formVote">
                        <div class="row g-4 mb-5">
                            <?php foreach ($candidates as $cand): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="candidate-card bg-white p-3 rounded-4 shadow-sm h-100 border">
                                        <img src="<?= $cand['photo_url'] ?>" class="w-100 rounded-4 mb-3" style="height: 250px; object-fit: cover;" alt="<?= $cand['name'] ?>">
                                        <div class="candidate-body">
                                            <span class="badge bg-primary mb-2">No. Urut <?= sprintf("%02d", $cand['number_order']) ?></span>
                                            <h5 class="fw-bold text-dark"><?= htmlspecialchars($cand['name']) ?></h5>
                                            <div class="candidate-info mb-3 small text-muted">
                                                <p class="mb-1"><i class="bi bi-card-text me-2"></i><?= $cand['nim'] ?></p>
                                                <p class="mb-0"><i class="bi bi-layers me-2"></i>Gen <?= $cand['generasi'] ?> (<?= $cand['divisi'] ?>)</p>
                                            </div>

                                            <div class="accordion mb-4" id="visimisi<?= $cand['id'] ?>">
                                                <div class="accordion-item border-0 bg-light rounded">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed small fw-bold bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#desc<?= $cand['id'] ?>">
                                                            Lihat Visi Misi
                                                        </button>
                                                    </h2>
                                                    <div id="desc<?= $cand['id'] ?>" class="accordion-collapse collapse">
                                                        <div class="accordion-body small">
                                                            <strong>Visi:</strong><br><?= nl2br(htmlspecialchars($cand['visi'])) ?><br><br>
                                                            <strong>Misi:</strong><br><?= nl2br(htmlspecialchars($cand['misi'])) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="radio" name="candidate_id" id="vote<?= $cand['id'] ?>" value="<?= $cand['id'] ?>" class="btn-check" required>
                                            <label for="vote<?= $cand['id'] ?>" class="btn btn-outline-primary w-100 fw-bold rounded-pill">Pilih Kandidat Ini</label>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="text-center pb-5">
                            <button type="button" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow" style="background: #1A237E;" onclick="confirmVote()">
                                <i class="bi bi-send-fill me-2"></i> Submit Vote Saya
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                <div class="modal-body text-center p-4">
                    <i class="bi bi-question-circle text-warning fs-1"></i>
                    <h4 class="fw-bold mt-3">Konfirmasi Pilihan</h4>
                    <p>Apakah Anda yakin ingin memilih kandidat ini? Pilihan Anda tidak dapat diubah setelah konfirmasi.</p>
                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <button class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary px-4 rounded-pill" onclick="submitForm()" style="background: #1A237E;">Ya, Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmVote() {
            const selected = document.querySelector('input[name="candidate_id"]:checked');
            if (!selected) {
                alert("Silakan pilih salah satu kandidat terlebih dahulu!");
                return;
            }
            new bootstrap.Modal(document.getElementById('confirmModal')).show();
        }

        function submitForm() {
            document.getElementById('formVote').submit();
        }
    </script>
    <script src="/assets/js/member-area/dashboard.js"></script>
</body>
</html>