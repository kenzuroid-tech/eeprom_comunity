<?php
$election = $election ?? [];
$candidates = $candidates ?? [];
$delegateName = $delegateName ?? 'Delegasi';
$hasVoted = $hasVoted ?? false;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting - <?= htmlspecialchars($election['title'] ?? 'EEPROM Voting') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }

        .top-bar {
            background: rgba(26, 35, 126, 0.95);
            backdrop-filter: blur(8px);
            /* Efek blur kaca */
            padding: 0.8rem 0;
            transition: all 0.3s ease;
        }

        .top-bar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-section img {
            width: 45px;
            height: 45px;
            background: white;
            padding: 5px;
            border-radius: 50%;
        }

        .logo-section h5 {
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .logo-section small {
            color: rgba(255, 255, 255, 0.8);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .main-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .election-header {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            text-align: center;
        }

        .election-header h1 {
            font-weight: 700;
            color: #1A237E;
            margin-bottom: 0.5rem;
        }

        .election-header p {
            color: #6c757d;
            margin: 0;
        }

        .alert-custom {
            border-radius: 15px;
            border: none;
            padding: 1.25rem;
            margin-bottom: 2rem;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .candidate-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            height: 100%;
            border: 3px solid transparent;
        }

        .candidate-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .candidate-card.selected {
            border-color: #667eea;
            box-shadow: 0 15px 50px rgba(102, 126, 234, 0.3);
        }

        .candidate-photo {
            width: 100%;
            height: 320px;
            object-fit: cover;
            background: linear-gradient(135deg, #1A237E, #283593);
        }

        .candidate-body {
            padding: 1.75rem;
        }

        .candidate-number {
            background: linear-gradient(135deg, #1A237E, #283593);
            color: white;
            font-size: 1.25rem;
            font-weight: 800;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .candidate-name {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1A237E;
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .candidate-info {
            text-align: center;
            margin-bottom: 1.25rem;
            padding-bottom: 1.25rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .candidate-info p {
            margin: 0.35rem 0;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .visi-misi {
            background: #f8f9fa;
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .visi-misi h6 {
            font-weight: 700;
            color: #1A237E;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .visi-misi p {
            margin: 0;
            color: #495057;
            font-size: 0.85rem;
            line-height: 1.6;
        }

        .btn-select {
            width: 100%;
            padding: 1rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.05rem;
            border: 3px solid #667eea;
            background: white;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .btn-select:hover,
        .btn-select.active {
            background: linear-gradient(135deg, #1A237E, #283593);
            color: white;
            transform: scale(1.03);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .submit-section {
            position: sticky;
            bottom: 0;
            /* Tempel di paling bawah */
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 1rem;
            border-radius: 20px 20px 0 0;
            /* Lengkungan hanya di atas */
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
            z-index: 999;
        }

        .btn-submit {
            background: linear-gradient(135deg, #1A237E, #283593);
            border: none;
            color: white;
            padding: 1.25rem 3rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.15rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .voted-section {
            background: white;
            padding: 4rem 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        .voted-section i {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 1.5rem;
        }

        .voted-section h2 {
            font-weight: 700;
            color: #1A237E;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {

            /* Membuat Navbar sangat ringkas */
            .top-bar {
                padding: 0.5rem 0;
            }

            .logo-section img {
                width: 32px;
                /* Perkecil logo */
                height: 32px;
            }

            .logo-section h5 {
                color: #ffffff;
                font-size: 0.9rem;
                font-weight: 800;
                letter-spacing: 0.5px;
            }

            .user-badge {
                font-size: 0.7rem;
                padding: 0.3rem 0.6rem;
                max-width: 120px;
                /* Batasi lebar nama agar tidak tabrakan */
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .btn-logout {
                padding: 0.3rem 0.6rem;
                font-size: 0.7rem;
                border-width: 1px;
            }

            .btn-submit {
                width: 100%;
                /* Penuhi layar secara horizontal */
                padding: 0.85rem 1.5rem;
                font-size: 1rem;
                border-radius: 15px;
            }

            .submit-section p {
                display: none;
                /* Sembunyikan teks bantuan di HP untuk menghemat ruang */
            }

            /* Election Header dibuat lebih compact agar kandidat cepat terlihat */
            .election-header {
                padding: 1rem;
                margin-bottom: 1rem;
                margin-top: 0.5rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            }

            .election-header h1 {
                font-size: 1.25rem;
                /* Judul pemilihan diperkecil */
                margin-bottom: 0.2rem;
            }

            .election-header p {
                font-size: 0.75rem;
                /* Teks tanggal diperkecil */
            }

            /* Kurangi jarak antar kontainer utama */
            .main-container {
                margin: 0.5rem auto;
            }
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="logo-section">
                <img src="/assets/images/eeprom_logo.png" alt="EEPROM">
                <div>
                    <h5 class="m-0 fw-bold">EEPROM POLINEMA</h5>
                    <small class="opacity-75">E-Voting System</small>
                </div>
            </div>
            <div class="user-info">
                <div class="user-badge">
                    <i class="bi bi-person-badge me-2"></i>
                    <?= htmlspecialchars($delegateName) ?>
                </div>
                <a href="/delegate/logout" class="btn btn-logout" onclick="return confirm('Yakin ingin logout?')">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Election Header -->
        <div class="election-header">
            <h1><?= htmlspecialchars($election['title'] ?? 'Pemilihan') ?></h1>
            <p class="mb-0">
                <i class="bi bi-calendar-event me-2"></i>
                <?= date('d F Y', strtotime($election['start_date'])) ?> - <?= date('d F Y', strtotime($election['end_date'])) ?>
            </p>
        </div>

        <?php
        $status = $_GET['status'] ?? '';

        if ($status == 'success'): ?>
            <div class="alert alert-success alert-custom">
                <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                <strong>Vote Berhasil!</strong> Terima kasih atas partisipasi Anda dalam pemilihan ini.
            </div>
        <?php elseif ($status == 'no_candidate'): ?>
            <div class="alert alert-warning alert-custom">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                <strong>Pilih Kandidat!</strong> Silakan pilih salah satu kandidat terlebih dahulu.
            </div>
        <?php elseif ($status == 'already_voted'): ?>
            <div class="alert alert-info alert-custom">
                <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                <strong>Sudah Voting!</strong> Anda sudah memberikan suara sebelumnya.
            </div>
        <?php endif; ?>

        <?php if ($hasVoted): ?>
            <!-- Sudah Vote -->
            <div class="voted-section">
                <i class="bi bi-check-circle-fill"></i>
                <h2>Terima Kasih!</h2>
                <p class="lead mb-4">Suara Anda telah berhasil tercatat dalam sistem.</p>
                <p class="text-muted">Partisipasi Anda sangat berarti untuk EEPROM Polinema.</p>
                <hr class="my-4">
                <a href="/delegate/logout" class="btn btn-outline-primary btn-lg rounded-pill px-5">
                    <i class="bi bi-box-arrow-right me-2"></i>Selesai & Logout
                </a>
            </div>

        <?php else: ?>
            <!-- Belum Vote -->
            <div class="alert alert-warning alert-custom">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Penting:</strong> Anda hanya memiliki <strong>SATU kali kesempatan</strong> untuk memilih. Pilihan tidak dapat diubah setelah konfirmasi.
            </div>

            <form action="/delegate/submit-vote" method="POST" id="voteForm">
                <div class="row g-4 mb-4">
                    <?php foreach ($candidates as $cand): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="candidate-card" data-candidate-id="<?= $cand['id'] ?>">
                                <img src="<?= htmlspecialchars($cand['photo_url']) ?>"
                                    alt="<?= htmlspecialchars($cand['name']) ?>"
                                    class="candidate-photo">

                                <div class="candidate-body">
                                    <div class="candidate-number">
                                        <?= sprintf("%02d", $cand['number_order']) ?>
                                    </div>

                                    <h4 class="candidate-name">
                                        <?= htmlspecialchars($cand['name']) ?>
                                    </h4>

                                    <div class="candidate-info">
                                        <p><?= htmlspecialchars($cand['nim']) ?></p>
                                        <p></i>Generasi <?= $cand['generasi'] ?></p>
                                    </div>

                                    <div class="visi-misi mb-3">
                                        <h6><i class="bi bi-lightbulb me-2"></i>Visi</h6>
                                        <p><?= nl2br(htmlspecialchars($cand['visi'])) ?></p>
                                    </div>

                                    <div class="visi-misi">
                                        <h6><i class="bi bi-list-check me-2"></i>Misi</h6>
                                        <p><?= nl2br(htmlspecialchars($cand['misi'])) ?></p>
                                    </div>

                                    <input type="radio"
                                        name="candidate_id"
                                        value="<?= $cand['id'] ?>"
                                        id="cand_<?= $cand['id'] ?>"
                                        class="d-none candidate-radio"
                                        required>

                                    <label for="cand_<?= $cand['id'] ?>" class="btn btn-select">
                                        <i class="bi bi-check-circle me-2"></i>
                                        <span>Pilih Kandidat Ini</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="submit-section">
                    <p class="mb-3 text-muted">
                        <i class="bi bi-shield-check me-2"></i>
                        Pastikan pilihan Anda sudah benar sebelum submit
                    </p>
                    <button type="button" class="btn btn-submit" onclick="confirmVote()">
                        <i class="bi bi-send-fill me-2"></i>
                        Submit Pilihan Saya
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-question-circle-fill text-warning" style="font-size: 4rem;"></i>
                    <h3 class="fw-bold mt-4 mb-3">Konfirmasi Pilihan Anda</h3>
                    <p class="text-muted mb-4">
                        Apakah Anda yakin dengan pilihan ini?<br>
                        <strong>Pilihan tidak dapat diubah</strong> setelah dikonfirmasi.
                    </p>
                    <div class="d-flex gap-3 justify-content-center">
                        <button type="button" class="btn btn-light btn-lg px-4 rounded-pill" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </button>
                        <button type="button" class="btn btn-primary btn-lg px-5 rounded-pill" onclick="submitVote()" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
                            <i class="bi bi-check-circle me-2"></i>Ya, Konfirmasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle candidate selection visual
        document.querySelectorAll('.candidate-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove selected class from all cards
                document.querySelectorAll('.candidate-card').forEach(card => {
                    card.classList.remove('selected');
                });

                // Remove active class from all buttons
                document.querySelectorAll('.btn-select').forEach(btn => {
                    btn.classList.remove('active');
                });

                // Add selected class to chosen card
                const card = this.closest('.candidate-card');
                card.classList.add('selected');

                // Add active class to button
                const button = card.querySelector('.btn-select');
                button.classList.add('active');

                // Smooth scroll to submit button
                setTimeout(() => {
                    document.querySelector('.submit-section').scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }, 300);
            });
        });

        // Confirm vote
        function confirmVote() {
            const selected = document.querySelector('input[name="candidate_id"]:checked');
            if (!selected) {
                alert('Silakan pilih salah satu kandidat terlebih dahulu!');
                return;
            }

            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        }

        // Submit vote
        function submitVote() {
            document.getElementById('voteForm').submit();
        }
    </script>
</body>

</html>