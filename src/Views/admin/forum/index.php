<?php

/**
 * Data dari ForumController
 * @var array $posts       Daftar postingan dari forum_posts JOIN members
 * @var array $stats       Statistik forum
 * @var array $adminData   Data profil admin
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
    <title>Forum Management - EEPROM Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">

    <style>
        :root {
            --primary-blue: #1A237E;
            --accent-orange: #FF5722;
            --bg-gray: #F1F5F9;
            --sidebar-width: 280px;
        }

        body {
            background-color: var(--bg-gray);
            font-family: 'Poppins', sans-serif;
        }

        /* --- Layout Adjustment --- */
        .main-content-area {
            /* Pastikan konten memiliki jarak agar tidak tertutup sidebar biru melayang */
            margin-left: calc(var(--sidebar-width) + 20px);
            padding: 30px;
            transition: 0.3s;
            min-height: 100vh;
        }

        /* --- Stats Card --- */
        .stat-card-admin {
            background: white;
            padding: 25px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.02);
            transition: 0.3s;
        }

        .stat-card-admin:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: #f0f3ff;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-right: 20px;
            color: var(--primary-blue);
        }

        .stat-green .stat-icon {
            background: #ecfdf5;
            color: #10b981;
        }

        .stat-orange .stat-icon {
            background: #fff7ed;
            color: var(--accent-orange);
        }

        /* --- UI Elements --- */
        .category-badge {
            background-color: #EEF2FF;
            color: #4F46E5;
            padding: 5px 12px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .widget-card-admin {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .table thead th {
            background-color: #F8FAFC;
            color: #64748B;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 15px;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #283593;
        }

        @media (max-width: 991.98px) {
            .main-content-area {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded-4 shadow-sm mb-4 px-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-primary border-0 me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list fs-3"></i>
                    </button>
                    <h4 class="m-0 fw-bold text-dark">Moderasi Forum</h4>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        id="adminDropdown" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>"
                            alt="Profile" width="38" height="38" class="rounded-circle me-2"
                            style="object-fit: cover; border: 2px solid var(--primary-blue); padding: 2px;">
                        <span class="d-none d-sm-inline text-dark fw-bold">
                            <?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                        <li><a class="dropdown-item py-2" href="/member/profile"><i class="bi bi-person me-2 text-primary"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stat-card-admin">
                        <div class="stat-icon"><i class="bi bi-chat-left-text"></i></div>
                        <div>
                            <h3 class="m-0 fw-bold"><?= number_format($stats['total_posts']) ?></h3>
                            <p class="small m-0 text-muted">Total Topik</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-admin stat-green">
                        <div class="stat-icon"><i class="bi bi-reply"></i></div>
                        <div>
                            <h3 class="m-0 fw-bold"><?= number_format($stats['total_replies']) ?></h3>
                            <p class="small m-0 text-muted">Total Balasan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-admin stat-orange">
                        <div class="stat-icon"><i class="bi bi-lightning-charge"></i></div>
                        <div>
                            <h3 class="m-0 fw-bold"><?= number_format($stats['active_7_days']) ?></h3>
                            <p class="small m-0 text-muted">Aktif (7 Hari Terakhir)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col-md-7">
                        <form method="GET" action="/admin/forum" class="row g-2">
                            <div class="col-7">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                    <input type="text" name="search" class="form-control bg-light border-0"
                                        placeholder="Cari topik..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <select name="category" class="form-select bg-light border-0">
                                    <option value="">Kategori</option>
                                    <option value="Riset & Teknologi" <?= ($_GET['category'] ?? '') == 'Riset & Teknologi' ? 'selected' : '' ?>>Riset</option>
                                    <option value="Lomba" <?= ($_GET['category'] ?? '') == 'Lomba' ? 'selected' : '' ?>>Lomba</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5 text-end">
                        <a href="/admin/forum/create" class="btn btn-warning fw-bold rounded-pill px-4 shadow-sm" style="background-color: var(--accent-orange); color: white; border: none;">
                            <i class="bi bi-plus-lg me-2"></i>Buat Topik Baru
                        </a>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin p-0 overflow-hidden shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">Judul Topik</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th class="text-center">Replies</th>
                                <th>Waktu</th>
                                <th class="text-center pe-4">Moderasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($posts)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Tidak ada postingan untuk dimoderasi.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($post['title']) ?></div>
                                            <small class="text-muted d-block text-truncate" style="max-width: 300px;">
                                                <?= htmlspecialchars(strip_tags($post['content'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <span class="small fw-semibold text-primary"><?= htmlspecialchars($post['nama_lengkap']) ?></span>
                                        </td>
                                        <td><span class="category-badge"><?= htmlspecialchars($post['category']) ?></span></td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-light text-dark border px-3">
                                                <?= $post['total_comments'] ?>
                                            </span>
                                        </td>
                                        <td><small class="text-muted"><?= date('d M Y', strtotime($post['created_at'])) ?></small></td>
                                        <td class="text-center pe-4">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                                <a href="/admin/forum/detail?id=<?= $post['id'] ?>"
                                                    class="btn btn-sm btn-white border-end" title="Lihat & Balas">
                                                    <i class="bi bi-eye-fill text-primary"></i>
                                                </a>
                                                <a href="/admin/forum/delete?id=<?= $post['id'] ?>"
                                                    class="btn btn-sm btn-white text-danger"
                                                    onclick="return confirm('Hapus topik ini?')" title="Hapus Permanen">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
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