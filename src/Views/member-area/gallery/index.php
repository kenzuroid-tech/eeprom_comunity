<?php

$galleryItems = $galleryItems ?? [];
$userData = $userData ?? [];
$profileData = $profileData ?? [];
$socialLinks = json_decode($profileData['social_links'] ?? '{}', true);

$userFoto = !empty($userData['foto_url']) ? $userData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($userData['nama_lengkap'] ?? 'Member');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/member-area/gallery/index.css">
    <!-- <style>
        :root { --primary-blue: #1A237E; }
        .widget-card { background: #fff; border-radius: 15px; padding: 25px; box-shadow: 0 0 20px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .gallery-item { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; height: 100%; }
        .gallery-item:hover { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0,0,0,0.15); }
        .gallery-img-wrapper { position: relative; width: 100%; height: 200px; overflow: hidden; }
        .gallery-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .category-badge { position: absolute; top: 10px; left: 10px; background: rgba(26, 35, 126, 0.85); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; backdrop-filter: blur(4px); }
        .gallery-info { padding: 15px; }
        .gallery-info h6 { font-weight: 700; margin-bottom: 5px; color: #333; font-size: 0.95rem; }
        .gallery-info .date { font-size: 0.8rem; color: #777; }
        .lightbox-img { max-width: 100%; max-height: 70vh; border-radius: 8px; }
    </style> -->
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">

            <nav class="top-navbar d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light border me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h5 class="m-0 fw-bold text-dark">Community Gallery</h5>
                    </div>
                </div>

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
            </nav>

            <div class="widget-card">
                <form action="" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Search Title</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Cari foto kegiatan..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Event">Event</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Competition">Competition</option>
                            <option value="Fun">Fun</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Tahun</label>
                        <select name="year" class="form-select">
                            <option value="">Semua Tahun</option>
                            <?php for ($i = date('Y'); $i >= 2023; $i--): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Filter</button>
                    </div>
                </form>
            </div>

            <div class="row g-4" id="galleryGrid">
                <?php if (empty($galleryItems)): ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">Belum ada foto kegiatan yang tersedia.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($galleryItems as $item): ?>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="gallery-item" onclick="openLightbox('<?= $item['image_url'] ?>', '<?= htmlspecialchars($item['title']) ?>')">
                                <div class="gallery-img-wrapper">
                                    <span class="category-badge"><?= htmlspecialchars($item['category']) ?></span>
                                    <img src="<?= $item['image_url'] ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                                </div>
                                <div class="gallery-info">
                                    <h6><?= htmlspecialchars($item['title']) ?></h6>
                                    <span class="date"><i class="bi bi-calendar-event me-1"></i><?= date('d M Y', strtotime($item['event_date'])) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <nav class="mt-5 d-flex justify-content-center">
                <ul class="pagination shadow-sm">
                    <li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
                    <li class="page-item active"><a class="page-link" href="#" style="background-color: var(--primary-blue); border-color: var(--primary-blue);">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
                </ul>
            </nav>

            <footer class="mt-5 text-center py-3 border-top small text-muted">
                © <?= date("Y"); ?> EEPROM POLINEMA
            </footer>
        </div>
    </div>

    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold" id="lightboxTitle">Image Title</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <img src="" id="lightboxImg" class="lightbox-img shadow-sm mb-3">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi Lightbox Dinamis
        function openLightbox(imgSrc, title) {
            document.getElementById('lightboxImg').src = imgSrc;
            document.getElementById('lightboxTitle').innerText = title;
            var myModal = new bootstrap.Modal(document.getElementById('lightboxModal'));
            myModal.show();
        }

        // Toggle Sidebar Mobile
        document.getElementById('mobile-toggle')?.addEventListener('click', function() {
            document.querySelector('.dashboard-wrapper').classList.toggle('sidebar-open');
        });
    </script>
    <script src="/assets/js/member-area/dashboard.js"></script>

</body>

</html>