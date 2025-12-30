<?php
$userData = $userData ?? [];
$documents = $documents ?? [];
$userFoto = !empty($userData['foto_url']) ? $userData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($userData['nama_lengkap'] ?? 'Member');
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
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">

            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="m-0 fw-bold">Documents & Archives</h4>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="<?= $userFoto ?>" alt="Profile" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover;">
                            <span class="d-none d-sm-inline text-dark fw-bold small"><?= htmlspecialchars($userData['nama_lengkap'] ?? 'Nisho') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="/member/profile"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="widget-card-docs">
                <form action="" method="GET" class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search documents by title...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select bg-light border-0">
                            <option value="">All Categories</option>
                            <option value="SOP">SOP</option>
                            <option value="Guidelines">Guidelines</option>
                            <option value="Forms">Forms</option>
                            <option value="Reports">Reports</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 border-0" style="background-color: #1A237E;">Filter</button>
                    </div>
                </form>
            </div>

            <div class="widget-card-docs">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Category</th>
                                <th>Size</th>
                                <th>Upload Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($documents)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No documents found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($documents as $doc): 
                                    // Logika Ikon berdasarkan ekstensi file
                                    $iconClass = 'bi-file-earmark-text-fill text-secondary';
                                    if (strpos($doc['title'], '.pdf') !== false) $iconClass = 'bi-file-earmark-pdf-fill text-danger';
                                    if (strpos($doc['title'], '.doc') !== false) $iconClass = 'bi-file-earmark-word-fill text-primary';
                                    if (strpos($doc['title'], '.xls') !== false) $iconClass = 'bi-file-earmark-excel-fill text-success';
                                    
                                    // Logika Warna Badge Kategori
                                    $badgeColor = 'bg-secondary';
                                    if ($doc['category'] == 'SOP') $badgeColor = 'bg-info text-dark';
                                    if ($doc['category'] == 'Forms') $badgeColor = 'bg-warning text-dark';
                                    if ($doc['category'] == 'Reports') $badgeColor = 'bg-success';
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi <?= $iconClass ?> fs-4 me-3"></i>
                                                <span class="fw-bold text-dark"><?= htmlspecialchars($doc['title']) ?></span>
                                            </div>
                                        </td>
                                        <td><span class="badge <?= $badgeColor ?>"><?= htmlspecialchars($doc['category']) ?></span></td>
                                        <td class="small"><?= htmlspecialchars($doc['file_size']) ?></td>
                                        <td class="small"><?= date('d M Y', strtotime($doc['uploaded_at'])) ?></td>
                                        <td class="text-center">
                                            <a href="<?= $doc['file_url'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
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
</body>

</html>