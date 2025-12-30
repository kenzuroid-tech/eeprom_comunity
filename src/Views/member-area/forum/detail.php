<?php

/**
 * File: src/Views/member-area/forum/detail.php
 */
$userData = $userData ?? [];
$post = $post ?? null;
$comments = $comments ?? [];

if (!$post) {
    echo "Topik tidak ditemukan.";
    exit;
}

$userFotoNavbar = !empty($userData['foto_url']) ? $userData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($userData['nama_lengkap'] ?? 'Member');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/member-area/forum/detail.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">

            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h5 class="m-0 fw-bold">Detail Topik Forum</h5>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?= $userFotoNavbar ?>" alt="Profile" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover;">
                        <span class="d-none d-sm-inline text-dark fw-bold small"><?= htmlspecialchars($userData['nama_lengkap'] ?? 'Nisho') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item" href="/member/profile"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid p-0">
                <a href="/member/forum" class="btn btn-outline-secondary btn-sm mb-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Forum
                </a>

                <div class="topic-header-card bg-white p-4 rounded shadow-sm mb-4">
                    <span class="badge bg-primary mb-3"><?= htmlspecialchars($post['category']) ?></span>
                    <h1 class="fw-bold text-dark h3 mb-4"><?= htmlspecialchars($post['title']) ?></h1>

                    <div class="original-post mb-4 border-bottom pb-4">
                        <p class="text-dark"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    </div>

                    <div class="author-info d-flex align-items-center">
                        <img src="<?= !empty($post['foto_url']) ? $post['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($post['nama_lengkap']) ?>" width="45" height="45" class="rounded-circle shadow-sm me-3" style="object-fit: cover;">
                        <div>
                            <p class="m-0 fw-bold text-dark"><?= htmlspecialchars($post['nama_lengkap']) ?></p>
                            <p class="m-0 small text-muted">Posted on <?= date('d M Y', strtotime($post['created_at'])) ?></p>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-chat-square-dots me-2 text-primary"></i>
                    Balasan Diskusi (<?= count($comments) ?>)
                </h5>

                <?php if (empty($comments)): ?>
                    <p class="text-muted italic">Belum ada balasan untuk topik ini.</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="reply-card bg-white p-3 rounded shadow-sm mb-3">
                            <div class="reply-header d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="<?= !empty($comment['foto_url']) ? $comment['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($comment['nama_lengkap']) ?>" width="35" height="35" class="rounded-circle" style="object-fit: cover;">
                                    <div>
                                        <p class="m-0 fw-bold text-dark small">
                                            <?= htmlspecialchars($comment['nama_lengkap']) ?>

                                            <?php
                                            // Perbaikan: Gunakan isset dan pastikan key yang dibandingkan benar
                                            if (isset($userData['user_id']) && $comment['user_id'] == $userData['user_id']):
                                            ?>
                                                <span class="badge bg-light text-dark fw-normal border ms-1">You</span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="m-0 text-muted" style="font-size: 0.7rem;">
                                            <?= date('d M Y, H:i', strtotime($comment['created_at'])) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="reply-content small">
                                <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="reply-form-card mt-5 bg-white p-4 rounded shadow-sm">
                    <h6 class="fw-bold mb-3"><i class="bi bi-reply me-2 text-primary"></i>Tulis Balasan</h6>
                    <form action="/member/forum/comment" method="POST">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <div class="mb-3">
                            <textarea name="comment" class="form-control" rows="4" placeholder="Tuliskan pendapat atau jawaban Anda di sini..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="bi bi-send-fill me-2"></i>Kirim Balasan
                            </button>
                        </div>
                    </form>
                </div>

                <footer class="mt-5 text-center py-4 border-top small text-muted">
                    © <?= date("Y") ?> EEPROM POLINEMA - Developed by Nisho
                </footer>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>