<?php
// Data dikirim dari AnnouncementController
$announcements = $announcements ?? [];
$userData = $userData ?? [];
$userFoto = !empty($userData['foto_url']) ? $userData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($userData['nama_lengkap'] ?? 'Member');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/member-area/announcements/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light border me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h5 class="m-0 fw-bold text-dark">Announcements</h5>
                    </div>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle p-1 rounded-pill hover-bg-light" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($fotoPath) ?>"
                            alt="Profile"
                            width="35"
                            height="35"
                            class="rounded-circle border"
                            style="object-fit: cover;">
                        <span class="d-none d-sm-inline text-dark fw-bold small ms-2 me-1">
                            <?= htmlspecialchars($userData['nama_lengkap'] ?? 'Member') ?>
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                        <div class="px-3 py-2 d-sm-none border-bottom mb-2">
                            <p class="m-0 fw-bold small text-truncate" style="max-width: 150px;">
                                <?= htmlspecialchars($userData['nama_lengkap'] ?? 'Member') ?>
                            </p>
                        </div>

                        <li>
                            <a class="dropdown-item py-2" href="/member/settings">
                                <i class="bi bi-gear me-2 text-secondary"></i>Pengaturan
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger py-2" href="/logout">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="row g-4 mb-4">
                <?php if (empty($announcements)): ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Tidak ada pengumuman untuk saat ini.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($announcements as $ann): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card announcement-card h-100 shadow-sm border-0">
                                <div class="card-body">
                                    <span class="badge mb-2 bg-primary"><?= htmlspecialchars($ann['category'] ?? 'Umum') ?></span>
                                    <h5 class="card-title fw-bold"><?= htmlspecialchars($ann['title']) ?></h5>
                                    <span class="publish-date text-muted small">
                                        <i class="bi bi-clock me-1"></i><?= date('d M Y', strtotime($ann['created_at'])) ?>
                                    </span>
                                    <p class="small text-muted mt-3 mb-4">
                                        <?= substr(strip_tags($ann['content']), 0, 100) ?>...
                                    </p>
                                    <a href="/member/announcements/detail?id=<?= $ann['id'] ?>" class="btn btn-primary w-100">Read More</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/member-area/dashboard.js"></script>

</body>

</html>