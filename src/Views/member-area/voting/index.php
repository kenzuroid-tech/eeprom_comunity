<?php
$userData = $userData ?? [];
$candidates = $candidates ?? [];
$userVote = $userVote ?? null;
$stats = $stats ?? [];

// Hitung total suara masuk untuk persentase
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

            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Pemilihan Ketua Umum</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="timer-box d-none d-md-block" id="topTimer">Voting Aktif</span>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="<?= $fotoPath ?>" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover;">
                            <span class="d-none d-sm-inline text-dark fw-bold small"><?= htmlspecialchars($userData['nama_lengkap'] ?? 'Member') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="/member/profile"><i class="bi bi-person me-2"></i>Profile Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php if ($userVote): ?>
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

            <?php else: ?>
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
</body>
</html>