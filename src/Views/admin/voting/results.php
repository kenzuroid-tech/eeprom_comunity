<?php

/**
 * Data yang dikirim dari VotingController::results()
 * @var array $electionInfo  Detail sesi pemilihan (id, title, end_date, status)
 * @var int   $totalMembers   Total DPT (Anggota Aktif)
 * @var int   $totalVotes     Total Suara Masuk
 * @var array $results        Hasil perolehan suara per kandidat
 * @var array $voteLogs       Log audit pemilih
 */

$electionInfo = $electionInfo ?? [];
$totalMembers = $totalMembers ?? 0;
$totalVotes = $totalVotes ?? 0;
$results = $results ?? [];
$voteLogs = $voteLogs ?? [];

// Perhitungan Statistik
$participationRate = ($totalMembers > 0) ? round(($totalVotes / $totalMembers) * 100, 1) : 0;
$abstain = $totalMembers - $totalVotes;

// Pemenang (Diambil dari indeks pertama karena query SQL sudah ORDER BY total_votes DESC)
$winner = $results[0] ?? null;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemilihan - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/voting/result.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <a href="/admin/voting" class="btn btn-sm btn-light border me-3"><i class="bi bi-arrow-left"></i></a>
                    <h4 class="m-0 fw-bold">Voting Results</h4>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-outline-success" onclick="window.print()"><i class="bi bi-printer me-1"></i> Cetak Laporan</button>
                </div>
            </nav>

            <div class="election-banner shadow-sm bg-primary text-white p-4 rounded mb-4" style="background: linear-gradient(45deg, #1a237e, #283593) !important;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <span class="badge bg-white text-primary mb-2">ID Sesi: #<?= $electionInfo['id'] ?? '0' ?></span>
                        <h2 class="fw-bold m-0"><?= htmlspecialchars($electionInfo['title'] ?? 'Belum Ada Pemilihan Aktif') ?></h2>
                        <p class="m-0 opacity-75 small mt-1">
                            <i class="bi bi-calendar-event me-2"></i>
                            Berakhir pada: <?= isset($electionInfo['end_date']) ? date('d F Y, H:i', strtotime($electionInfo['end_date'])) : '-' ?> WIB
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <span class="badge bg-dark px-3 py-2 fs-6 rounded-pill">
                            <i class="bi bi-lock-fill me-2"></i><?= strtoupper($electionInfo['status'] ?? 'UNKNOWN') ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm p-3">
                        <h6 class="text-muted small fw-bold text-uppercase">Pemilih Sah (DPT)</h6>
                        <h3 class="fw-bold m-0 text-primary"><?= $totalMembers ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm p-3" style="border-left: 4px solid #28a745 !important;">
                        <h6 class="text-muted small fw-bold text-uppercase">Suara Masuk</h6>
                        <h3 class="fw-bold m-0 text-success"><?= $totalVotes ?></h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm p-3" style="border-left: 4px solid #fd7e14 !important;">
                        <h6 class="text-muted small fw-bold text-uppercase">Partisipasi</h6>
                        <h3 class="fw-bold m-0" style="color: #fd7e14;"><?= $participationRate ?>%</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm p-3" style="border-left: 4px solid #6c757d !important;">
                        <h6 class="text-muted small fw-bold text-uppercase">Abstain</h6>
                        <h3 class="fw-bold m-0 text-secondary"><?= $abstain ?></h3>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <h5 class="fw-bold mb-4"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Visualisasi Perolehan Suara</h5>

                        <?php
                        $colors = ['bg-primary', 'bg-info', 'bg-warning', 'bg-success'];
                        if (empty($results)): ?>
                            <div class="text-center py-5">
                                <p class="text-muted">Data perolehan suara belum tersedia.</p>
                            </div>
                            <?php else:
                            foreach ($results as $index => $res):
                                $percent = ($totalVotes > 0) ? round(($res['total_votes'] / $totalVotes) * 100, 1) : 0;
                                $colorClass = $colors[$index % count($colors)];
                            ?>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1 fw-bold">
                                        <span>#<?= $res['number_order'] ?> - <?= htmlspecialchars($res['name']) ?></span>
                                        <span><?= $res['total_votes'] ?> Suara (<?= $percent ?>%)</span>
                                    </div>
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar <?= $colorClass ?> progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= $percent ?>%"></div>
                                    </div>
                                </div>
                        <?php endforeach;
                        endif; ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 h-100 text-center justify-content-center">
                        <?php if ($winner && $totalVotes > 0): ?>
                            <i class="bi bi-trophy-fill text-warning fs-1 mb-2"></i>
                            <div class="position-relative d-inline-block mx-auto mb-3">
                                <img src="<?= !empty($winner['photo_url']) ? $winner['photo_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($winner['name']) . '&size=128' ?>"
                                    class="rounded-circle border border-4 border-success shadow-sm" width="120" height="120" style="object-fit:cover;">
                            </div>
                            <h4 class="fw-bold mb-1"><?= htmlspecialchars($winner['name']) ?></h4>
                            <p class="text-muted m-0"><?= $winner['total_votes'] ?> Suara (<?= round(($winner['total_votes'] / $totalVotes) * 100, 1) ?>%)</p>
                            <div class="badge bg-success px-4 py-2 rounded-pill mt-3 fs-6">TERPILIH</div>
                        <?php else: ?>
                            <div class="py-5">
                                <i class="bi bi-info-circle text-muted fs-1"></i>
                                <p class="text-muted mt-2">Menunggu hasil perhitungan...</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-shield-check me-2 text-primary"></i>Audit Log Kehadiran Pemilih</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Pemilih</th>
                                <th>NIM</th>
                                <th>Gen</th>
                                <th>Pilihan (Audit)</th>
                                <th>Waktu Vote</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            <?php if (empty($voteLogs)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada pemilih yang memberikan suara.</td>
                                </tr>
                                <?php else:
                                foreach ($voteLogs as $log): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($log['nama_lengkap']) ?></td>
                                        <td><?= htmlspecialchars($log['nim']) ?></td>
                                        <td><?= $log['generasi'] ?></td>
                                        <td><span class="badge bg-light text-dark border">Kandidat #<?= $log['number_order'] ?></span></td>
                                        <td><?= date('d M Y, H:i', strtotime($log['voted_at'])) ?></td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>

</body>

</html>