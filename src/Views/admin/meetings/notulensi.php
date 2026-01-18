<?php

/**
 * Data dari MeetingController
 * @var array $meetings   Daftar rapat yang memiliki notulensi
 * @var array $adminData  Data profil admin untuk navbar
 */
$meetings = $meetings ?? [];

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
    <title>Notulensi Rapat - EEPROM Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <style>
        :root {
            --primary-blue: #1A237E;
            --accent-orange: #FF5722;
        }

        .main-content-area {
            padding: 30px;
            transition: 0.3s;
        }

        .widget-card-admin {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .notulen-preview {
            max-width: 300px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Notulen Rapat</h4>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover; border: 1px solid #ddd;">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?></span>
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

            <div class="widget-card-admin">
                <form class="row g-3" method="GET" action="/admin/meetings/notulensi">
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari judul rapat atau hasil notulensi..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold" style="background-color: var(--primary-blue);">Cari Notulen</button>
                    </div>
                </form>
            </div>

            <div class="widget-card-admin p-0 border-0 overflow-hidden shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Detail Rapat</th>
                                <th>Lokasi</th>
                                <th>Preview Notulensi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($meetings)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Belum ada data notulensi rapat.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($meetings as $m): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($m['title']) ?></div>
                                            <small class="text-muted"><i class="bi bi-calendar-check me-1"></i><?= date('d M Y', strtotime($m['date'])) ?></small>
                                        </td>
                                        <td><i class="bi bi-geo-alt me-1 text-danger"></i><?= htmlspecialchars($m['location']) ?></td>
                                        <td>
                                            <span class="notulen-preview">
                                                <?= htmlspecialchars(strip_tags($m['notulensi'])) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm rounded">
                                                <button class="btn btn-sm btn-white text-primary" title="Lihat Notulen"
                                                    onclick='viewNotulen(<?= json_encode($m) ?>)'>
                                                    <i class="bi bi-file-earmark-text-fill"></i> Baca
                                                </button>
                                                <a href="/admin/meetings/edit?id=<?= $m['id'] ?>" class="btn btn-sm btn-white text-warning" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
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

    <div class="modal fade" id="modalViewNotulen" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Detail Notulensi Rapat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <h4 id="mTitle" class="fw-bold text-primary-blue mb-1"></h4>
                    <p class="text-muted small mb-4" id="mMeta"></p>
                    <hr>
                    <div id="mContent" style="white-space: pre-wrap; line-height: 1.6;"></div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer me-2"></i>Cetak</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewNotulen(data) {
            document.getElementById('mTitle').innerText = data.title;
            document.getElementById('mMeta').innerHTML = `<i class="bi bi-calendar-event me-2"></i> ${data.date} | <i class="bi bi-geo-alt me-2 ms-2"></i> ${data.location}`;
            document.getElementById('mContent').innerText = data.notulensi;
            new bootstrap.Modal(document.getElementById('modalViewNotulen')).show();
        }
    </script>
</body>

</html>