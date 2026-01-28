<?php

/**
 * File: src/Views/admin/forum/create.php
 * @var array $adminData Data profil admin untuk navbar
 */
$adminData = $adminData ?? [];
$adminFotoNavbar = !empty($adminData['foto_url'])
    ? $adminData['foto_url']
    : '/assets/images/default-avatar.png';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Topik Forum - EEPROM Admin</title>
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
            color: #334155;
        }

        /* --- Layout Adjustment agar tidak tertutup Sidebar --- */
        .main-content-area {
            margin-left: calc(var(--sidebar-width) + 20px);
            padding: 30px;
            transition: 0.3s;
            min-height: 100vh;
        }

        /* --- UI Elements --- */
        .navbar {
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .widget-card-admin {
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        /* --- Form Styling --- */
        .form-label {
            font-size: 0.85rem;
            color: #64748B;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control,
        .form-select {
            border-radius: 15px;
            padding: 12px 20px;
            border: 1px solid #E2E8F0;
            background-color: #F8FAFC;
            transition: 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 4px rgba(26, 35, 126, 0.08);
            border-color: var(--primary-blue);
            background-color: white;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
        }

        .btn-primary:hover {
            background-color: var(--secondary-blue);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.2);
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
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>" width="38" height="38" class="rounded-circle me-2" style="object-fit: cover; border: 2px solid var(--primary-blue); padding: 2px;">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Admin') ?></span>
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

            <div class="mb-4">
                <a href="/admin/forum" class="text-decoration-none text-muted small fw-bold">
                    <i class="bi bi-chevron-left me-1"></i> Kembali ke Daftar Moderasi
                </a>
            </div>

            <div class="widget-card-admin">
                <div class="mb-5 border-bottom pb-4">
                    <h3 class="fw-bold text-dark mb-2">Terbitkan Topik Baru</h3>
                    <p class="text-muted m-0">Gunakan form ini untuk membuat pengumuman resmi atau memulai diskusi di forum komunitas.</p>
                </div>

                <form id="createTopicForm" action="/member/forum/store" method="POST">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="category" class="form-label fw-bold">Kategori Forum</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="" selected disabled>Pilih Kategori...</option>
                                <option value="Announcement">📢 Announcement (Resmi)</option>
                                <option value="Discussion">💬 Discussion</option>
                                <option value="Internal Divisi">🔒 Internal Divisi</option>
                                <option value="Riset & Teknologi">🤖 Riset & Teknologi</option>
                                <option value="Other">✨ Other</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="topic_title" class="form-label fw-bold">Judul Topik</label>
                            <input type="text" class="form-control" id="topic_title" name="title"
                                placeholder="Contoh: Pengumuman Jadwal Ganti Latihan Robotika..." required>
                        </div>

                        <div class="col-12">
                            <label for="topic_content" class="form-label fw-bold">Isi Konten / Detail</label>
                            <textarea class="form-control" id="topic_content" name="content" rows="12"
                                placeholder="Tuliskan detail pengumuman atau instruksi di sini secara mendalam..." required></textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-end border-top mt-5 pt-4">
                        <button type="reset" class="btn btn-light rounded-pill px-4 fw-bold text-muted">Batal & Reset</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                            <i class="bi bi-send-check-fill me-2"></i>Terbitkan Topik
                        </button>
                    </div>
                </form>
            </div>

            <footer class="mt-5 text-center py-4 small text-muted opacity-50">
                © <?= date("Y"); ?> EEPROM POLINEMA - Tim Pengembang
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>