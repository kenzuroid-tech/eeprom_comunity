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
    <style>
        :root {
            --primary-blue: #1A237E;
            --secondary-blue: #3F51B5;
            --accent-orange: #FF5722;
            --bg-gray: #F1F5F9;
            --sidebar-width: 280px;
        }

        body {
            background-color: var(--bg-gray);
            font-family: 'Poppins', sans-serif;
        }

        /* Memastikan konten tidak tertabrak sidebar melayang */
        .main-content-area {
            margin-left: calc(var(--sidebar-width) + 20px);
            padding: 30px;
            transition: 0.3s;
            min-height: 100vh;
        }

        .navbar {
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .widget-card-admin {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .notulen-preview {
            max-width: 350px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.85rem;
            color: #64748B;
        }

        /* Styling Tabel */
        .table thead th {
            background-color: #F8FAFC;
            color: #64748B;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 15px;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: var(--secondary-blue);
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
                <form method="GET" action="/admin/meetings/notulensi">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 px-3"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control bg-light border-0 py-2"
                                    placeholder="Cari berdasarkan judul rapat atau hasil pembahasan..."
                                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">
                                <i class="bi bi-filter me-2"></i>Filter Notulen
                            </button>
                        </div>
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
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-muted">Detail Hasil Rapat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="printableArea">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary-subtle p-3 rounded-3 me-3">
                            <i class="bi bi-file-earmark-text text-primary fs-3"></i>
                        </div>
                        <div>
                            <h3 id="mTitle" class="fw-bold text-dark mb-0"></h3>
                            <div id="mMeta" class="small text-muted"></div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <h6 class="fw-bold text-uppercase small text-muted mb-3">Isi Notulensi / Hasil Pembahasan:</h6>
                    <div id="mContent" class="p-3 bg-light rounded-3" style="white-space: pre-wrap; line-height: 1.8; color: #334155;"></div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow" onclick="printNotulen()">
                        <i class="bi bi-printer me-2"></i>Cetak Notulen
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewNotulen(data) {
            document.getElementById('mTitle').innerText = data.title;
            document.getElementById('mMeta').innerHTML = `
            <span class="me-3"><i class="bi bi-calendar-event me-1"></i> ${data.date}</span>
            <span><i class="bi bi-geo-alt me-1"></i> ${data.location}</span>
        `;
            document.getElementById('mContent').innerText = data.notulensi;
            new bootstrap.Modal(document.getElementById('modalViewNotulen')).show();
        }

        function printNotulen() {
            const content = document.getElementById('printableArea').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = `
            <div style="padding: 40px; font-family: 'Poppins', sans-serif;">
                <h2 style="text-align:center; border-bottom: 2px solid #333; padding-bottom:10px;">NOTULENSI RAPAT EEPROM</h2>
                ${content}
            </div>`;

            window.print();
            location.reload(); // Reload untuk mengembalikan tampilan dashboard
        }
    </script>
</body>

</html>