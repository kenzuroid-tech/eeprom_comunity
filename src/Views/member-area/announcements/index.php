<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/member-area/announcements/index.css">
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
                    <h4 class="m-0 fw-bold">Announcements</h4>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=Nisho&background=1A237E&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
                            <span class="d-none d-sm-inline text-dark fw-bold small">Nisho</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="filter-card">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="searchTitle" class="form-control border-0 bg-light" placeholder="Search by title...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select id="filterType" class="form-select border-0 bg-light">
                            <option value="All">All Types</option>
                            <option value="Urgent">Urgent</option>
                            <option value="Info">Info</option>
                            <option value="Event">Event</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-6 col-lg-4">
                    <div class="announcement-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="type-badge badge-urgent">Urgent</span>
                                <span class="type-badge badge-new">New</span>
                            </div>
                            <h5 class="card-title">Persiapan Lomba KRI 2024 Wilayah II</h5>
                            <span class="publish-date"><i class="bi bi-clock me-1"></i>20 Dec 2024</span>
                            <p class="small text-muted mb-4">Diharapkan seluruh anggota divisi robotik berkumpul di sekre malam ini untuk membahas progress...</p>
                            <button class="btn btn-read-more w-100">Read More</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="announcement-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="type-badge badge-info">Info</span>
                                <span class="type-badge badge-new">New</span>
                            </div>
                            <h5 class="card-title">Update Jadwal Inventaris Lab</h5>
                            <span class="publish-date"><i class="bi bi-clock me-1"></i>19 Dec 2024</span>
                            <p class="small text-muted mb-4">Terdapat perubahan jadwal piket dan penggunaan lab robotika selama masa libur semester ganjil...</p>
                            <button class="btn btn-read-more w-100">Read More</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="announcement-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="type-badge badge-event">Event</span>
                            </div>
                            <h5 class="card-title">Workshop IoT dan Mikrokontroler</h5>
                            <span class="publish-date"><i class="bi bi-clock me-1"></i>15 Dec 2024</span>
                            <p class="small text-muted mb-4">Bergabunglah dalam workshop internal mengenai implementasi ESP32 untuk monitoring sensor...</p>
                            <button class="btn btn-read-more w-100">Read More</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="announcement-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="type-badge badge-info">Info</span>
                            </div>
                            <h5 class="card-title">Pembayaran Iuran Kas Semester Genap</h5>
                            <span class="publish-date"><i class="bi bi-clock me-1"></i>10 Dec 2024</span>
                            <p class="small text-muted mb-4">Diberitahukan kepada seluruh anggota mengenai rincian iuran kas untuk mendukung kegiatan lomba...</p>
                            <button class="btn btn-read-more w-100">Read More</button>
                        </div>
                    </div>
                </div>
            </div>

            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="bi bi-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/member-area/index.js"></script>
</body>
</html>