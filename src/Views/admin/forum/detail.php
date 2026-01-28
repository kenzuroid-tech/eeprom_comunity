<?php

/**
 * Data dari ForumController (Admin)
 * @var array $post       Detail postingan JOIN members
 * @var array $comments   Daftar balasan JOIN members
 * @var array $adminData  Data profil admin untuk navbar
 */
$post = $post ?? null;
$comments = $comments ?? [];

if (!$post) {
    echo "Topik tidak ditemukan.";
    exit;
}

// Logika Foto Profil Admin untuk Navbar
$adminFotoNavbar = !empty($adminData['foto_url'])
    ? $adminData['foto_url']
    : '/assets/images/default-avatar.png';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderasi: <?= htmlspecialchars($post['title']) ?> - EEPROM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <style>
        .topic-header-card {
            border-left: 5px solid #0d6efd;
        }

        .reply-card {
            border-left: 3px solid #dee2e6;
            transition: 0.3s;
        }

        .reply-card:hover {
            border-left-color: #0d6efd;
            background-color: #f8f9fa !important;
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">

            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Moderasi Detail Forum</h4>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover; border: 1px solid #ddd;">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item py-2" href="/member/profile"><i class="bi bi-person me-2 text-primary"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid p-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="/admin/forum" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Moderasi
                    </a>
                    <a href="/admin/forum/delete?id=<?= $post['id'] ?>" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Hapus seluruh topik ini?')">
                        <i class="bi bi-trash me-1"></i> Hapus Topik
                    </a>
                </div>

                <div class="topic-header-card bg-white p-4 rounded shadow-sm mb-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-primary"><?= htmlspecialchars($post['category']) ?></span>
                        <small class="text-muted">ID Topik: #<?= $post['id'] ?></small>
                    </div>

                    <h1 class="fw-bold text-dark h4 mb-4"><?= htmlspecialchars($post['title']) ?></h1>

                    <div class="original-post mb-4 border-bottom pb-4">
                        <p class="text-dark" style="line-height: 1.6;"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    </div>

                    <div class="author-info d-flex align-items-center">
                        <img src="<?= !empty($post['foto_url']) ? $post['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($post['nama_lengkap']) ?>" width="45" height="45" class="rounded-circle shadow-sm me-3" style="object-fit: cover;">
                        <div>
                            <p class="m-0 fw-bold text-dark"><?= htmlspecialchars($post['nama_lengkap']) ?></p>
                            <p class="m-0 small text-muted">Diposting pada <?= date('d M Y, H:i', strtotime($post['created_at'])) ?></p>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mb-4 d-flex align-items-center">
                    <i class="bi bi-chat-left-text me-2 text-primary"></i>
                    Daftar Balasan (<?= count($comments) ?>)
                </h5>

                <?php if (empty($comments)): ?>
                    <div class="bg-white p-5 rounded text-center shadow-sm">
                        <i class="bi bi-chat-dots text-muted display-4"></i>
                        <p class="text-muted mt-3">Belum ada balasan untuk topik ini.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="reply-card bg-white p-3 rounded shadow-sm mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <img src="<?= !empty($comment['foto_url']) ? $comment['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($comment['nama_lengkap']) ?>" width="35" height="35" class="rounded-circle" style="object-fit: cover;">
                                    <div>
                                        <p class="m-0 fw-bold text-dark small">
                                            <?= htmlspecialchars($comment['nama_lengkap']) ?>
                                        </p>
                                        <p class="m-0 text-muted" style="font-size: 0.7rem;">
                                            <?= date('d M Y, H:i', strtotime($comment['created_at'])) ?>
                                        </p>
                                    </div>
                                </div>
                                <a href="/admin/forum/delete-comment?id=<?= $comment['id'] ?>&post_id=<?= $post['id'] ?>" class="btn btn-link text-danger p-0" title="Hapus Komentar" onclick="return confirm('Hapus komentar ini?')">
                                    <i class="bi bi-x-circle-fill"></i>
                                </a>
                            </div>
                            <div class="reply-content small mt-2 ps-5">
                                <p class="mb-0 text-dark"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>

            <footer class="mt-5 text-center py-4 border-top small text-muted">
                © <?= date("Y") ?> EEPROM POLINEMA - Developed by Nisho
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>