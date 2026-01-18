<?php

/**
 * Data dari AboutController
 * @var array $aboutData  Data dari tabel organization_info
 * @var array $adminData  Data profil admin untuk navbar
 */
$about = $aboutData ?? [];
$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : '/assets/images/default-avatar.png';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <style>
        :root {
            --primary-blue: #1A237E;
            --accent-orange: #FF5722;
        }

        .widget-card-admin {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .nav-tabs.custom-tabs .nav-link {
            color: #666;
            border: none;
            font-weight: 600;
            padding: 10px 20px;
        }

        .nav-tabs.custom-tabs .nav-link.active {
            color: var(--primary-blue);
            border-bottom: 3px solid var(--primary-blue);
        }

        .btn-accent {
            background-color: var(--accent-orange);
            color: white;
            font-weight: 600;
        }

        .btn-accent:hover {
            background-color: #e64a19;
            color: white;
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
                    <h4 class="m-0 fw-bold text-dark">About Management</h4>
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
                <ul class="nav nav-tabs custom-tabs mb-4" id="aboutTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#aboutContent">About EEPROM</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#visionContent">Visi Misi & Motto</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="aboutContent">
                        <form action="/admin/about/update" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tentang EEPROM</label>
                                <textarea name="about_text" class="form-control" rows="5"><?= htmlspecialchars($about['about_text'] ?? '') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sejarah</label>
                                <textarea name="history_text" class="form-control" rows="4"><?= htmlspecialchars($about['history_text'] ?? '') ?></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Tahun Berdiri</label>
                                <input name="established_year" type="number" class="form-control" style="width: 150px;" value="<?= htmlspecialchars($about['established_year'] ?? '2015') ?>">
                            </div>
                            <button type="submit" class="btn btn-accent px-4 shadow-sm">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="visionContent">
                        <form action="/admin/about/update-vision" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Visi</label>
                                <textarea name="vision" class="form-control" rows="3"><?= htmlspecialchars($about['vision'] ?? '') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Misi</label>
                                <textarea name="mission" class="form-control" rows="4" placeholder="Gunakan baris baru untuk setiap poin misi..."><?= htmlspecialchars($about['mission'] ?? '') ?></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Motto</label>
                                <input name="motto" type="text" class="form-control" value="<?= htmlspecialchars($about['motto'] ?? '') ?>">
                            </div>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="bi bi-save me-2"></i>Update Visi Misi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>