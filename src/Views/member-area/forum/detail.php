<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Detail - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/member-area/forum/detail.css">
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
                    <h5 class="m-0 fw-bold">Detail Topik Forum</h5>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=Member+EEPROM&background=1A237E&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
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

            <div class="container-fluid p-0">
                <a href="/member/forum.php" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Forum
                </a>

                <div class="topic-header-card">
                    <span class="status-badge category-discussion">Discussion</span>
                    <h1 class="fw-bold text-dark mb-3">Progress Riset Robot KRI 2024 Divisi Software</h1>
                    
                    <div class="original-post mb-4">
                        <p>Halo rekan-rekan software, saya ingin bertanya terkait progress algoritma PID untuk robot KRI tahun ini. Apakah ada kendala saat tuning nilai Kp, Ki, dan Kd? Terutama saat menghadapi permukaan arena yang tidak rata.</p>
                    </div>

                    <div class="author-info">
                        <img src="https://ui-avatars.com/api/?name=Admin+Software&background=1A237E&color=fff" width="45" class="rounded-circle shadow-sm" alt="Author">
                        <div>
                            <p class="m-0 fw-bold text-dark">Admin Software</p>
                            <p class="m-0 small text-muted">Posted on 20 Des 2024 • <i class="bi bi-eye me-1"></i> 156 Views</p>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mb-4"><i class="bi bi-chat-square-dots me-2 text-primary"></i>Balasan Diskusi (3)</h5>

                <div class="reply-card">
                    <div class="reply-header">
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Nisho&background=FF5722&color=fff" width="35" class="rounded-circle" alt="User">
                            <div>
                                <p class="m-0 fw-bold text-dark small">Nisho <span class="badge bg-light text-dark fw-normal border ms-1">You</span></p>
                                <p class="m-0 text-muted" style="font-size: 0.7rem;">2 jam yang lalu</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm text-primary p-0" title="Reply"><i class="bi bi-reply-fill"></i></button>
                            <button class="btn btn-sm text-danger p-0" title="Delete"><i class="bi bi-trash3-fill"></i></button>
                        </div>
                    </div>
                    <div class="reply-content small">
                        <p>Izin menjawab, untuk tuning PID di arena tidak rata, kami mencoba menambahkan fungsi <i>moving average filter</i> pada data sensor sebelum masuk ke perhitungan PID. Sejauh ini respon robot lebih stabil.</p>
                    </div>
                </div>

                <div class="reply-card">
                    <div class="reply-header">
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Budi&background=3F51B5&color=fff" width="35" class="rounded-circle" alt="User">
                            <div>
                                <p class="m-0 fw-bold text-dark small">Budi S.</p>
                                <p class="m-0 text-muted" style="font-size: 0.7rem;">1 jam yang lalu</p>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-sm text-primary p-0"><i class="bi bi-reply-fill"></i></button>
                        </div>
                    </div>
                    <div class="reply-content small">
                        <p>Setuju dengan Nisho. Mungkin bisa dicoba juga implementasi <i>Anti-Windup</i> pada nilai Integral untuk mencegah overshoot berlebih.</p>
                    </div>
                </div>

                <div class="reply-form-card mt-5">
                    <h6 class="fw-bold mb-3"><i class="bi bi-reply me-2"></i>Tulis Balasan</h6>
                    <form id="replyForm">
                        <div class="mb-3">
                            <textarea class="form-control" rows="4" placeholder="Tuliskan pendapat atau jawaban Anda di sini..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-submit-reply">
                                <i class="bi bi-send-fill me-2"></i>Kirim Balasan
                            </button>
                        </div>
                    </form>
                </div>

                <footer class="mt-5 text-center py-4 border-top small text-muted">
                    © 2024 EEPROM POLINEMA - Elektronika & Robotika Mahasiswa
                </footer>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/member-area/forum/detail.js"></script>
</body>
</html>