<?php
// Pastikan variabel dari Controller tersedia
$results = $results ?? [];
$totalVotes = $totalVotes ?? 0;
$candidates = $candidates ?? [];
$totalMembers = $totalMembers ?? 1; // Anda perlu mengirim total user dari controller
$participationRate = ($totalVotes > 0) ? round(($totalVotes / $totalMembers) * 100, 1) : 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Voting Management - EEPROM POLINEMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin/voting/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Voting Management</h4>
                </div>
            </nav>

            <div class="active-voting-banner bg-white p-4 rounded shadow-sm mb-4">
                <div class="row align-items-center mb-4">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-success rounded-pill"><i class="bi bi-record-fill me-1"></i>Voting Aktif</span>
                            <h4 class="m-0 text-primary fw-bold">Pemilihan Ketua Umum Real-time</h4>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <form action="/admin/voting/reset" method="POST" onsubmit="return confirm('PERINGATAN: Semua suara akan dihapus secara permanen. Lanjutkan?')">
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reset Semua Suara
                            </button>
                        </form>
                    </div>
                </div>

                <div class="row g-3 mb-4 text-center">
                    <div class="col-md-4">
                        <div class="p-3 border rounded">
                            <h6 class="text-muted">Suara Masuk</h6>
                            <div class="h3 fw-bold mb-0"><?= $totalVotes ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded">
                            <h6 class="text-muted">Partisipasi</h6>
                            <div class="h3 fw-bold mb-0 text-success"><?= $participationRate ?>%</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded">
                            <h6 class="text-muted">Total Kandidat</h6>
                            <div class="h3 fw-bold mb-0"><?= count($candidates) ?></div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 align-items-center">
                    <div class="col-lg-8">
                        <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Hasil Perolehan Sementara</h6>
                        <div class="p-3 bg-light rounded border">
                            <?php
                            $colors = ['bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger'];
                            foreach ($results as $index => $res):
                                $percent = ($totalVotes > 0) ? round(($res['total_votes'] / $totalVotes) * 100, 1) : 0;
                                $colorClass = $colors[$index % count($colors)];
                            ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1 small fw-bold">
                                        <span>#<?= $res['number_order'] ?> - <?= htmlspecialchars($res['name']) ?></span>
                                        <span><?= $percent ?>% (<?= $res['total_votes'] ?> Votes)</span>
                                    </div>
                                    <div class="progress" style="height: 15px;">
                                        <div class="progress-bar <?= $colorClass ?> progress-bar-striped progress-bar-animated"
                                            role="progressbar" style="width: <?= $percent ?>%"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex flex-column gap-2">
                        <a href="/admin/voting/candidates" class="btn btn-primary fw-bold p-3">
                            <i class="bi bi-people me-2"></i>Kelola Daftar Kandidat
                        </a>
                        <button class="btn btn-outline-secondary fw-bold p-3" onclick="window.location.reload()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh Data Live
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/admin/dashboard.js"></script>

</body>

</html>