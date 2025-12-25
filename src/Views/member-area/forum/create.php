<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Topik Baru - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/member-area/forum/create.css">
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
                    <h4 class="m-0 fw-bold">Buat Topik Baru</h4>
                </div>
                
                <div class="d-flex align-items-center gap-3">
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
                <div class="mb-4">
                    <h5 class="fw-bold text-dark"><i class="bi bi-plus-circle me-2 text-primary"></i>Mulai Diskusi Baru</h5>
                    <p class="text-muted small">Bagikan ide, pertanyaan, atau informasi kepada anggota lainnya.</p>
                </div>

                <form id="createTopicForm">
                    <div class="mb-4">
                        <label for="category" class="form-label">Kategori Diskusi</label>
                        <select class="form-select" id="category" required>
                            <option value="" selected disabled>Pilih Kategori...</option>
                            <option value="Discussion">Discussion</option>
                            <option value="Question">Question</option>
                            <option value="Announcement">Announcement</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="topic_title" class="form-label">Judul Topik</label>
                        <input type="text" class="form-control" id="topic_title" placeholder="Ketikkan judul topik yang singkat dan jelas..." required>
                    </div>

                    <div class="mb-5">
                        <label for="topic_content" class="form-label">Isi Konten</label>
                        <textarea class="form-control" id="topic_content" rows="10" placeholder="Jelaskan detail diskusi Anda di sini..." required></textarea>
                    </div>

                    <div class="d-flex gap-3 justify-content-end border-top pt-4">
                        <a href="/member/forum.php" class="btn btn-cancel">Batal</a>
                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-send-fill me-2"></i>Terbitkan Topik
                        </button>
                    </div>
                </form>
            </div>

            <footer class="mt-5 text-center py-3 border-top small text-muted">
                © 2024 EEPROM POLINEMA - Forum Internal Anggota
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/member-area/forum/create.js"></script>
</body>
</html>