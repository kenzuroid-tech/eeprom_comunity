<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/member-area/gallery/index.css">

</head>

<body>
    <div class="dashboard-wrapper">
        <?php include __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">

            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="m-0 fw-bold"><i class="#"></i>Community Gallery</h4>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=Member+EEPROM&background=1A237E&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
                            <span class="d-none d-sm-inline text-dark fw-bold small">Nisho</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="/member/profile.php"><i class="bi bi-person me-2"></i>Profile Saya</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="widget-card">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Search Title</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari foto kegiatan...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Kategori</label>
                        <select class="form-select">
                            <option selected>Semua Kategori</option>
                            <option>Event</option>
                            <option>Meeting</option>
                            <option>Competition</option>
                            <option>Fun</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Tahun</label>
                        <select class="form-select">
                            <option selected>Semua Tahun</option>
                            <option>2025</option>
                            <option>2024</option>
                            <option>2023</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100 fw-bold" style="border-radius: 8px;">Filter</button>
                    </div>
                </div>
            </div>

            <div class="row g-4" id="galleryGrid">
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="gallery-item" onclick="openLightbox('https://images.unsplash.com/photo-1581092160562-40aa08e78837', 'Workshop Robotika 2024')">
                        <div class="gallery-img-wrapper">
                            <span class="category-badge">Event</span>
                            <img src="#" alt="Gallery">
                        </div>
                        <div class="gallery-info">
                            <h6>Workshop Robotika 2024</h6>
                            <span class="date"><i class="bi bi-calendar-event me-1"></i>15 Mar 2024</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="gallery-item" onclick="openLightbox('https://images.unsplash.com/photo-1517245386807-bb43f82c33c4', 'Rapat Koordinasi Divisi')">
                        <div class="gallery-img-wrapper">
                            <span class="category-badge">Meeting</span>
                            <img src="#" alt="Gallery">
                        </div>
                        <div class="gallery-info">
                            <h6>Rapat Koordinasi Divisi</h6>
                            <span class="date"><i class="bi bi-calendar-event me-1"></i>10 Feb 2024</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="gallery-item" onclick="openLightbox('https://images.unsplash.com/photo-1531482615713-2afd69097998', 'Persiapan KRI 2024')">
                        <div class="gallery-img-wrapper">
                            <span class="category-badge">Competition</span>
                            <img src="#" alt="Gallery">
                        </div>
                        <div class="gallery-info">
                            <h6>Persiapan KRI 2024</h6>
                            <span class="date"><i class="bi bi-calendar-event me-1"></i>05 Jan 2024</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="gallery-item" onclick="openLightbox('https://images.unsplash.com/photo-1523240795612-9a054b0db644', 'Gathering EEPROM V15')">
                        <div class="gallery-img-wrapper">
                            <span class="category-badge">Fun</span>
                            <img src="#" alt="Gallery">
                        </div>
                        <div class="gallery-info">
                            <h6>Gathering EEPROM V15</h6>
                            <span class="date"><i class="bi bi-calendar-event me-1"></i>20 Dec 2023</span>
                        </div>
                    </div>
                </div>

            </div>

            <nav class="mt-5 d-flex justify-content-center">
                <ul class="pagination shadow-sm">
                    <li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
                    <li class="page-item active"><a class="page-link" href="#" style="background-color: var(--primary-blue); border-color: var(--primary-blue);">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
                </ul>
            </nav>

            <footer class="mt-5 text-center py-3 border-top small text-muted">
                © <?php echo date("Y"); ?> EEPROM POLINEMA
            </footer>

        </div>
    </div>

    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold" id="lightboxTitle">Image Title</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <img src="" id="lightboxImg" class="lightbox-img shadow-sm mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-chevron-left me-1"></i>Prev</button>
                        <button class="btn btn-sm btn-outline-secondary">Next<i class="bi bi-chevron-right ms-1"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/member-area/gallery/index.js"></script>
</body>

</html>