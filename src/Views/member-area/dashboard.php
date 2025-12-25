<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/member-area/dashboard.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../layouts/sidebar-ma.php'; ?>
        
        <div id="mainContentWrapper" class="main-content-area">

            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-none d-md-block">
                        <h5 class="m-0 fw-bold text-dark">Selamat Datang, Nisho! 👋</h5>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <a href="#" class="text-dark position-relative" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2" style="width: 250px;">
                            <li><h6 class="dropdown-header">Notifikasi Terbaru</h6></li>
                            <li><a class="dropdown-item small rounded" href="#">Rapat Divisi Software besok!</a></li>
                            <li><a class="dropdown-item small rounded" href="#">Voting Ketua Umum dibuka.</a></li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=Nisho&background=FF5722&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
                            <span class="d-none d-sm-inline text-dark fw-bold small">Nisho</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile Saya</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="row g-4 mb-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card-member">
                        <p class="small text-muted mb-1">Kehadiran</p>
                        <h3 class="fw-bold m-0" style="color: var(--primary-blue);">85%</h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member">
                        <p class="small text-muted mb-1">Total Rapat</p>
                        <h3 class="fw-bold m-0" style="color: var(--primary-blue);">24</h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member">
                        <p class="small text-muted mb-1">Status Voting</p>
                        <span class="badge bg-warning text-dark">Belum Vote</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member">
                        <p class="small text-muted mb-1">Active Since</p>
                        <h6 class="fw-bold m-0" style="color: var(--primary-blue);">Jan 2023</h6>
                    </div>
                </div>
            </div>

            <!-- <div class="widget-card">
                <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Akses Cepat</h6>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#" class="btn btn-outline-primary btn-action"><i class="bi bi-pencil-square"></i> Edit Profile</a>
                    <a href="#" class="btn btn-outline-primary btn-action"><i class="bi bi-images"></i> Gallery</a>
                    <a href="#" class="btn btn-outline-primary btn-action"><i class="bi bi-chat-left-text"></i> Forum Diskusi</a>
                    <a href="#" class="btn btn-danger btn-action"><i class="bi bi-box-arrow-in-right"></i> Vote Ketua Umum</a>
                </div>
            </div> -->

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="widget-card">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2">Rapat Mendatang</h6>
                        
                        <div class="meeting-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1 small">Rapat Progress Robot KRI</h6>
                                    <p class="mb-0 text-muted" style="font-size: 0.75rem;"><i class="bi bi-calendar3 me-1"></i>24 Des - 18:30 WIB</p>
                                    <p class="mb-0 text-muted" style="font-size: 0.75rem;"><i class="bi bi-geo-alt me-1"></i>Lab. Robotika Gd. AF</p>
                                </div>
                                <span class="badge bg-secondary" style="font-size: 0.65rem;">Belum Absen</span>
                            </div>
                        </div>

                        <div class="meeting-item" style="border-left-color: #28a745;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1 small">Briefing Lomba KRSTI</h6>
                                    <p class="mb-0 text-muted" style="font-size: 0.75rem;"><i class="bi bi-calendar3 me-1"></i>27 Des - 15:00 WIB</p>
                                    <p class="mb-0 text-muted" style="font-size: 0.75rem;"><i class="bi bi-geo-alt me-1"></i>Zoom Meeting</p>
                                </div>
                                <span class="badge bg-success" style="font-size: 0.65rem;">Hadir</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="widget-card">
                        <h6 class="fw-bold mb-3 text-dark border-bottom pb-2">Pengumuman Terbaru</h6>
                        
                        <div class="announcement-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-danger mb-1" style="font-size: 0.6rem;">Urgent</span>
                                <span class="text-muted" style="font-size: 0.7rem;">20 Des 2025</span>
                            </div>
                            <h6 class="fw-bold mb-1 small">Pendaftaran Re-Sertifikasi Anggota</h6>
                            <a href="#" class="small text-primary text-decoration-none" style="font-size: 0.75rem;">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                        </div>

                        <div class="announcement-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-info mb-1" style="font-size: 0.6rem;">Info</span>
                                <span class="text-muted" style="font-size: 0.7rem;">18 Des 2025</span>
                            </div>
                            <h6 class="fw-bold mb-1 small">Update Inventaris Komponen Lab</h6>
                            <a href="#" class="small text-primary text-decoration-none" style="font-size: 0.75rem;">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/member-area/dashboard.js"></script>
</body>
</html>