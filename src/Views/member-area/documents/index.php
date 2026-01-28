<?php
$userData = $userData ?? [];
$documents = $documents ?? [];
$userFoto = !empty($userData['foto_url']) ? $userData['foto_url'] : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($userData['nama_lengkap'] ?? 'Member');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents & Archives - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/member-area/documents/index.css">

    <style>
        /* Custom Mobile Optimization */
        @media (max-width: 768px) {
            .main-content-area { padding: 15px !important; }
            .top-navbar h5 { font-size: 1.1rem; }

            /* Sembunyikan Header Tabel di Mobile */
            .table-responsive thead { display: none; }

            /* Ubah baris tabel menjadi tampilan Card */
            .table-responsive tbody tr {
                display: block;
                margin-bottom: 1.2rem;
                border: 1px solid #edf2f7;
                border-radius: 12px;
                padding: 12px;
                background: #fff;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }

            .table-responsive tbody td {
                display: block;
                text-align: right;
                padding: 8px 0;
                border: none;
                position: relative;
            }

            /* Tambahkan Label di sebelah kiri menggunakan Atribut data-label */
            .table-responsive tbody td::before {
                content: attr(data-label);
                float: left;
                font-weight: 600;
                color: #718096;
                font-size: 0.85rem;
            }

            /* Penyesuaian khusus elemen di dalam sel */
            .table-responsive tbody td .d-flex { justify-content: flex-end; }
            .table-responsive tbody td:first-child { 
                text-align: left; 
                border-bottom: 1px solid #f7fafc;
                margin-bottom: 5px;
                padding-bottom: 10px;
            }
            .table-responsive tbody td:first-child::before { display: none; }
            .table-responsive tbody td:last-child { 
                text-align: center; 
                padding-top: 15px;
                border-top: 1px dashed #e2e8f0;
            }
            .table-responsive tbody td:last-child::before { display: none; }
            
            .btn-download-mobile { width: 100%; }
        }

        .widget-card-docs {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.04);
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">

            <nav class="top-navbar d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light border me-2 me-md-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h5 class="m-0 fw-bold text-dark">Dokumen dan Arsip</h5>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle p-1 rounded-pill hover-bg-light" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($userFoto) ?>" alt="Profile" width="32" height="32" class="rounded-circle border" style="object-fit: cover;">
                        <span class="d-none d-sm-inline text-dark fw-bold small ms-2 me-1">
                            <?= htmlspecialchars($userData['nama_lengkap'] ?? 'Member') ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate slideIn">
                        <li class="px-3 py-2 d-sm-none border-bottom mb-2">
                            <p class="m-0 fw-bold small text-truncate" style="max-width: 150px;">
                                <?= htmlspecialchars($userData['nama_lengkap'] ?? 'Member') ?>
                            </p>
                        </li>
                        <li><a class="dropdown-item py-2" href="/member/settings"><i class="bi bi-gear me-2 text-secondary"></i>Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="widget-card-docs">
                <form action="" method="GET" class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari judul dokumen..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <select name="category" class="form-select bg-light border-0">
                            <option value="">Semua Kategori</option>
                            <option value="SOP" <?= ($_GET['category'] ?? '') == 'SOP' ? 'selected' : '' ?>>SOP</option>
                            <option value="Guidelines" <?= ($_GET['category'] ?? '') == 'Guidelines' ? 'selected' : '' ?>>Guidelines</option>
                            <option value="Forms" <?= ($_GET['category'] ?? '') == 'Forms' ? 'selected' : '' ?>>Forms</option>
                            <option value="Reports" <?= ($_GET['category'] ?? '') == 'Reports' ? 'selected' : '' ?>>Reports</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-6">
                        <button type="submit" class="btn btn-primary w-100 border-0" style="background-color: #1A237E;">Filter</button>
                    </div>
                </form>
            </div>

            <div class="widget-card-docs">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama File</th>
                                <th>Kategori</th>
                                <th>Ukuran</th>
                                <th>Tgl Unggah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($documents)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-file-earmark-x d-block mb-2 fs-2"></i>
                                        Tidak ada dokumen ditemukan.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($documents as $doc):
                                    // Ikon berdasarkan judul/ekstensi
                                    $iconClass = 'bi-file-earmark-text-fill text-secondary';
                                    $titleLower = strtolower($doc['title']);
                                    if (strpos($titleLower, '.pdf') !== false) $iconClass = 'bi-file-earmark-pdf-fill text-danger';
                                    elseif (strpos($titleLower, '.doc') !== false) $iconClass = 'bi-file-earmark-word-fill text-primary';
                                    elseif (strpos($titleLower, '.xls') !== false) $iconClass = 'bi-file-earmark-excel-fill text-success';

                                    // Warna Badge
                                    $badgeColor = 'bg-secondary';
                                    $cat = $doc['category'];
                                    if ($cat == 'SOP') $badgeColor = 'bg-info text-dark';
                                    elseif ($cat == 'Forms') $badgeColor = 'bg-warning text-dark';
                                    elseif ($cat == 'Reports') $badgeColor = 'bg-success';
                                ?>
                                    <tr>
                                        <td data-label="Nama File">
                                            <div class="d-flex align-items-center">
                                                <i class="bi <?= $iconClass ?> fs-4 me-3"></i>
                                                <span class="fw-bold text-dark text-wrap"><?= htmlspecialchars($doc['title']) ?></span>
                                            </div>
                                        </td>
                                        <td data-label="Kategori"><span class="badge <?= $badgeColor ?>"><?= htmlspecialchars($doc['category']) ?></span></td>
                                        <td data-label="Ukuran" class="small text-muted"><?= htmlspecialchars($doc['file_size']) ?></td>
                                        <td data-label="Tgl Unggah" class="small text-muted"><?= date('d M Y', strtotime($doc['uploaded_at'])) ?></td>
                                        <td class="text-center">
                                            <a href="<?= $doc['file_url'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-download-mobile" target="_blank">
                                                <i class="bi bi-download me-2"></i>Download
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <footer class="mt-5 text-center py-3 border-top small text-muted">
                © <?= date("Y"); ?> EEPROM POLINEMA - Developed by Nisho
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/member-area/dashboard.js"></script>

</body>

</html>