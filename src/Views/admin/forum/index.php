<?php
/**
 * Data dari ForumController
 * @var array $posts       Daftar postingan dari forum_posts JOIN members
 * @var array $stats       Statistik forum (total_posts, total_replies, active_7_days)
 * @var array $adminData   Data profil admin untuk sidebar & navbar
 */
$posts = $posts ?? [];
$stats = $stats ?? ['total_posts' => 0, 'total_replies' => 0, 'active_7_days' => 0];

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
    <title>Forum Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="m-0 fw-bold">Moderasi Forum Diskusi</h4>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>"
                            alt="Profile" width="35" height="35" class="rounded-circle me-2"
                            style="object-fit: cover; border: 1px solid #ddd;">
                        <span class="d-none d-sm-inline text-dark fw-bold">
                            <?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="adminDropdown">
                        <li>
                            <a class="dropdown-item py-2" href="/member/profile">
                                <i class="bi bi-person me-2 text-primary"></i>Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger py-2" href="/logout">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stat-card-admin">
                        <i class="bi bi-journal-text stat-icon"></i>
                        <div>
                            <h3 class="m-0 fw-bold"><?= number_format($stats['total_posts']) ?></h3>
                            <p class="small m-0 text-muted">Total Topik</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-admin stat-green">
                        <i class="bi bi-reply-all stat-icon"></i>
                        <div>
                            <h3 class="m-0 fw-bold"><?= number_format($stats['total_replies']) ?></h3>
                            <p class="small m-0 text-muted">Total Balasan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-admin stat-orange">
                        <i class="bi bi-graph-up-arrow stat-icon"></i>
                        <div>
                            <h3 class="m-0 fw-bold"><?= number_format($stats['active_7_days']) ?></h3>
                            <p class="small m-0 text-muted">Topik Aktif (7 Hari)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin">
                <form class="row g-3" method="GET" action="/admin/forum">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0"
                                placeholder="Cari berdasarkan judul topik..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select bg-light border-0">
                            <option value="">Semua Kategori</option>
                            <option value="Riset & Teknologi" <?= ($_GET['category'] ?? '') == 'Riset & Teknologi' ? 'selected' : '' ?>>Riset & Teknologi</option>
                            <option value="Lomba Robotika" <?= ($_GET['category'] ?? '') == 'Lomba Robotika' ? 'selected' : '' ?>>Lomba Robotika</option>
                            <option value="Internal Divisi" <?= ($_GET['category'] ?? '') == 'Internal Divisi' ? 'selected' : '' ?>>Internal Divisi</option>
                            <option value="Umum" <?= ($_GET['category'] ?? '') == 'Umum' ? 'selected' : '' ?>>Umum</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Filter</button>
                    </div>
                </form>
            </div>

            <div class="widget-card-admin p-0 border-0 overflow-hidden shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">Judul Topik</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th class="text-center">Replies</th>
                                <th>Tanggal Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($posts)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Tidak ada postingan forum.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($post['title']) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars(substr($post['content'], 0, 50)) ?>...</small>
                                        </td>
                                        <td><?= htmlspecialchars($post['nama_lengkap']) ?></td>
                                        <td><span class="category-badge"><?= htmlspecialchars($post['category']) ?></span></td>
                                        <td class="text-center"><span class="badge bg-info text-dark rounded-pill"><?= $post['total_comments'] ?></span></td>
                                        <td><?= date('d M Y', strtotime($post['created_at'])) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="/member/forum/detail?id=<?= $post['id'] ?>" class="btn btn-sm btn-light text-primary" title="Lihat"><i class="bi bi-eye"></i></a>
                                                <a href="/admin/forum/delete?id=<?= $post['id'] ?>" class="btn btn-sm btn-light text-danger" title="Hapus" onclick="return confirm('Hapus topik ini?')"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
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