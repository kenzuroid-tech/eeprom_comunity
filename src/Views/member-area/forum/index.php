<?php

/**
 * File: src/Views/member-area/forum/index.php
 */

$userData = $userData ?? [];
$posts = $posts ?? []; // Data dari ForumController

$userFoto = !empty($userData['foto_url']) ? $userData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($userData['nama_lengkap'] ?? 'Member');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Diskusi - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/member-area/forum/index.css">
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
                        <h5 class="m-0 fw-bold text-dark">Forum Diskusi</h5>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="/member/forum/create" class="btn btn-primary d-none d-md-flex align-items-center rounded-pill px-4 shadow-sm">
                        <i class="bi bi-plus-lg me-2"></i>
                        <span class="small fw-bold">Buat Topik</span>
                    </a>

                    <a href="/member/forum/create" class="btn btn-primary d-md-none rounded-circle p-2 shadow-sm">
                        <i class="bi bi-plus-lg"></i>
                    </a>

                    <div class="vr d-none d-sm-block mx-1" style="height: 30px;"></div>

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
                </div>
            </nav>

            <div class="widget-card-forum mb-4 p-3 bg-white rounded shadow-sm">
                <form action="/member/forum" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari judul diskusi..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select bg-light border-0">
                            <option value="">Semua Kategori</option>
                            <option value="Discussion">Discussion</option>
                            <option value="Question">Question</option>
                            <option value="Announcement">Announcement</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sort" class="form-select bg-light border-0">
                            <option value="latest">Terbaru</option>
                            <option value="popular">Paling Populer</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100 border-0">
                            <i class="bi bi-filter"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="forum-topics">
                <?php if (empty($posts)): ?>
                    <div class="text-center py-5 bg-white rounded shadow-sm">
                        <i class="bi bi-chat-square-dots text-muted fs-1"></i>
                        <p class="text-muted mt-2">Belum ada topik diskusi yang tersedia.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($posts as $post):
                        // Logika penentuan Ikon Kategori
                        $iconClass = 'cat-discussion';
                        $icon = 'bi-chat-left-dots';

                        if ($post['category'] == 'Question') {
                            $iconClass = 'cat-question';
                            $icon = 'bi-question-circle';
                        } elseif ($post['category'] == 'Announcement') {
                            $iconClass = 'cat-announcement';
                            $icon = 'bi-megaphone';
                        }
                    ?>
                        <a href="/member/forum/detail?id=<?= $post['id'] ?>" class="topic-card d-flex align-items-center p-3 mb-3 bg-white rounded shadow-sm text-decoration-none text-dark border-start border-4 border-primary">
                            <div class="category-icon <?= $iconClass ?> me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 45px; height: 45px; background: #f0f2f5;">
                                <i class="bi <?= $icon ?> fs-5"></i>
                            </div>
                            <div class="topic-info flex-grow-1">
                                <div class="topic-title fw-bold mb-1">
                                    <?= htmlspecialchars($post['title']) ?>
                                    <?php if (strtotime($post['created_at']) > strtotime('-2 days')): ?>
                                        <span class="badge bg-danger ms-1" style="font-size: 0.6rem;">New</span>
                                    <?php endif; ?>
                                </div>
                                <div class="topic-meta small text-muted">
                                    <span><?= htmlspecialchars($post['nama_lengkap']) ?></span>
                                    <span class="mx-2">•</span>
                                    <span><i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($post['created_at'])) ?></span>
                                </div>
                            </div>
                            <div class="topic-stats text-center px-4 d-none d-md-block border-start border-end">
                                <div class="fw-bold"><?= $post['comment_count'] ?></div>
                                <div class="small text-muted">Balasan</div>
                            </div>
                            <div class="last-reply text-end ps-4 d-none d-lg-block" style="min-width: 180px;">
                                <div class="small fw-bold">Terakhir Aktif</div>
                                <div class="small text-muted"><?= date('H:i', strtotime($post['created_at'])) ?> WIB</div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link border-0 shadow-sm mx-1 rounded" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link border-0 shadow-sm mx-1 rounded" href="#" style="background-color: #1A237E;">1</a></li>
                    <li class="page-item"><a class="page-link border-0 bg-white text-dark shadow-sm mx-1 rounded" href="#">Next</a></li>
                </ul>
            </nav>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>