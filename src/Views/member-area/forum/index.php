<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Diskusi - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/member-area/forum/index.css">
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
                    <h4 class="m-0 fw-bold">Forum Diskusi</h4>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <a href="/src/Views/member-area/forum/create.php" class="btn btn-new-topic d-none d-md-block text-decoration-none">
                        <i class="bi bi-plus-lg me-2"></i>Buat Topik Baru
                    </a>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=Member+EEPROM&background=1A237E&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
                            <span class="d-none d-sm-inline text-dark fw-bold small">Nisho</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="widget-card-forum">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-0" placeholder="Cari judul topik diskusi...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select bg-light border-0">
                            <option value="">Semua Kategori</option>
                            <option value="Discussion">Discussion</option>
                            <option value="Question">Question</option>
                            <option value="Announcement">Announcement</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select bg-light border-0">
                            <option value="Latest">Terbaru</option>
                            <option value="Most Replied">Paling Banyak Balasan</option>
                            <option value="Most Viewed">Paling Banyak Dilihat</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-primary w-100 border-0" style="background-color: var(--secondary-blue);">
                            <i class="bi bi-sliders"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-md-none mb-4">
                <button class="btn btn-new-topic w-100">
                    <i class="bi bi-plus-lg me-2"></i>Buat Topik Baru
                </button>
            </div>

            <div class="forum-topics">
                
                <a href="#" class="topic-card">
                    <div class="category-icon cat-discussion">
                        <i class="bi bi-chat-left-dots"></i>
                    </div>
                    <div class="topic-info">
                        <div class="topic-title">
                            Progress Riset Robot KRI 2024 Divisi Software
                            <span class="badge-new">New</span>
                        </div>
                        <div class="topic-meta">
                            <img src="https://ui-avatars.com/api/?name=Admin+A&background=primary&color=fff" width="20" class="rounded-circle">
                            <span>Admin A</span>
                            <span><i class="bi bi-calendar3 me-1"></i>2 jam yang lalu</span>
                        </div>
                    </div>
                    <div class="topic-stats">
                        <div class="fw-bold text-dark">15</div>
                        <div class="small text-muted">Balasan</div>
                    </div>
                    <div class="last-reply text-muted">
                        <div class="fw-bold text-dark mb-1">Terakhir oleh Nisho</div>
                        <div>10 menit yang lalu</div>
                    </div>
                </a>

                <a href="#" class="topic-card">
                    <div class="category-icon cat-question">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <div class="topic-info">
                        <div class="topic-title">Kendala Upload Program ke ESP32 di Windows 11</div>
                        <div class="topic-meta">
                            <img src="https://ui-avatars.com/api/?name=Budi&background=warning&color=fff" width="20" class="rounded-circle">
                            <span>Budi</span>
                            <span><i class="bi bi-calendar3 me-1"></i>Kemarin</span>
                        </div>
                    </div>
                    <div class="topic-stats">
                        <div class="fw-bold text-dark">8</div>
                        <div class="small text-muted">Balasan</div>
                    </div>
                    <div class="last-reply text-muted">
                        <div class="fw-bold text-dark mb-1">Terakhir oleh Siti</div>
                        <div>5 jam yang lalu</div>
                    </div>
                </a>

                <a href="#" class="topic-card">
                    <div class="category-icon cat-announcement">
                        <i class="bi bi-megaphone"></i>
                    </div>
                    <div class="topic-info">
                        <div class="topic-title">Panduan Penggunaan Alat Lab Robotika Baru</div>
                    </div>
                    <div class="topic-meta">
                        <img src="https://ui-avatars.com/api/?name=Super+Admin&background=1A237E&color=fff" width="20" class="rounded-circle">
                        <span>Super Admin</span>
                        <span><i class="bi bi-calendar3 me-1"></i>3 hari yang lalu</span>
                    </div>
                    <div class="topic-stats">
                        <div class="fw-bold text-dark">2</div>
                        <div class="small text-muted">Balasan</div>
                    </div>
                    <div class="last-reply text-muted">
                        <div class="fw-bold text-dark mb-1">Terakhir oleh Admin</div>
                        <div>1 hari yang lalu</div>
                    </div>
                </a>

            </div>

            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link border-0 bg-white shadow-sm mx-1 rounded" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link border-0 shadow-sm mx-1 rounded" href="#" style="background-color: var(--primary-blue);">1</a></li>
                    <li class="page-item"><a class="page-link border-0 bg-white text-dark shadow-sm mx-1 rounded" href="#">2</a></li>
                    <li class="page-item"><a class="page-link border-0 bg-white text-dark shadow-sm mx-1 rounded" href="#">Next</a></li>
                </ul>
            </nav>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/member-area/index.js"></script>
</body>
</html>