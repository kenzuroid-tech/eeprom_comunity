<?php
// Data satu pengumuman dikirim dari Controller
$announcement = $announcement ?? null;
$userData = $userData ?? [];
$userFoto = !empty($userData['foto_url']) ? $userData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($userData['nama_lengkap'] ?? 'Member');

if (!$announcement) {
    echo "Pengumuman tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($announcement['title']) ?> - EEPROM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/member-area/announcements/detail.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../../layouts/sidebar-ma.php'; ?>
        
        <div id="mainContentWrapper" class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center p-3">
                <a href="/member/announcements" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <div class="d-flex align-items-center">
                    <img src="<?= $userFoto ?>" width="35" height="35" class="rounded-circle me-2">
                    <span class="fw-bold small"><?= htmlspecialchars($userData['nama_lengkap'] ?? 'Member') ?></span>
                </div>
            </nav>

            <div class="container py-4">
                <article class="bg-white p-4 rounded shadow-sm">
                    <header class="mb-4">
                        <span class="badge bg-primary mb-2"><?= htmlspecialchars($announcement['category']) ?></span>
                        <h2 class="fw-bold"><?= htmlspecialchars($announcement['title']) ?></h2>
                        <p class="text-muted small">
                            Diposting oleh <strong><?= htmlspecialchars($announcement['author'] ?? 'Admin') ?></strong> 
                            pada <?= date('d F Y', strtotime($announcement['created_at'])) ?>
                        </p>
                    </header>
                    <hr>
                    <section class="content">
                        <?= nl2br(htmlspecialchars($announcement['content'])) ?>
                    </section>
                </article>
            </div>
        </div>
    </div>
</body>
</html>