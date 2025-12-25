<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengumuman - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/member-area/announcements/detail.css">
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
                    <h5 class="m-0 fw-bold">Detail Pengumuman</h5>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=Member+EEPROM&background=1A237E&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
                            <span class="d-none d-sm-inline text-dark fw-bold small">Active Member</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                <a href="/src/Views/member-area/announcements/index.php" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke List Pengumuman
                </a>

                <article class="article-card">
                    <header>
                        <span class="type-badge badge-urgent">Urgent</span>
                        <h1 class="article-title">Persiapan Lomba KRI 2024 Wilayah II</h1>
                        <div class="article-meta">
                            <span><i class="bi bi-calendar3 me-2"></i>20 Desember 2024</span>
                            <span><i class="bi bi-person-fill me-2"></i>Admin EEPROM (Super Admin)</span>
                        </div>
                    </header>

                    <div class="article-content">
                        <p>Halo Rekan-rekan Anggota EEPROM,</p>
                        <p>Diberitahukan kepada seluruh anggota, khususnya <strong>Divisi Robotik</strong>, bahwasanya jadwal perlombaan Kontes Robot Indonesia (KRI) 2024 Wilayah II telah resmi dirilis. Berdasarkan jadwal tersebut, kita memiliki waktu kurang lebih 2 minggu untuk melakukan finalisasi pada unit robot.</p>
                        <p>Sehubungan dengan hal tersebut, akan diadakan koordinasi teknis yang wajib dihadiri pada:</p>
                        <ul>
                            <li><strong>Hari/Tanggal:</strong> Senin, 23 Desember 2024</li>
                            <li><strong>Waktu:</strong> 18.30 WIB - Selesai</li>
                            <li><strong>Tempat:</strong> Lab Robotika Gedung AF</li>
                        </ul>
                        <p>Mengingat pentingnya agenda ini untuk kelancaran riset dan persiapan kompetisi, dimohon kehadirannya tepat waktu. Jika berhalangan hadir, harap segera melapor kepada masing-masing ketua divisi.</p>
                        <p>Terima kasih atas perhatian dan kerja samanya.</p>
                    </div>

                    <section class="attachment-section">
                        <h6 class="fw-bold mb-3"><i class="bi bi-paperclip me-2 text-primary"></i>Lampiran File</h6>
                        
                        <div class="attachment-item">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-3"></i>
                                <div>
                                    <p class="m-0 fw-bold small">Jadwal_KRI_2024_Wilayah2.pdf</p>
                                    <span class="text-muted" style="font-size: 0.7rem;">1.2 MB</span>
                                </div>
                            </div>
                            <button class="btn btn-download">
                                <i class="bi bi-download me-1"></i> Download
                            </button>
                        </div>

                        <div class="attachment-item">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-image-fill text-success fs-4 me-3"></i>
                                <div>
                                    <p class="m-0 fw-bold small">Layout_Arena_Kontes.jpg</p>
                                    <span class="text-muted" style="font-size: 0.7rem;">850 KB</span>
                                </div>
                            </div>
                            <button class="btn btn-download">
                                <i class="bi bi-download me-1"></i> Download
                            </button>
                        </div>
                    </section>
                </article>

                <footer class="mt-5 text-center py-3 border-top small text-muted">
                    © 2024 EEPROM POLINEMA - Tim Robotika Elektro
                </footer>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/member-area/announcements/detail.js"></script>
</body>
</html>