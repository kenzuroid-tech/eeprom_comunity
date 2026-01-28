<?php
// Menggunakan dirname untuk mendapatkan root directory project secara konsisten
$configPath = dirname(__DIR__, 2) . '/../config/connection.php';

if (file_exists($configPath)) {
    $conn = require_once $configPath;
} else {
    die("Error: File connection.php tidak ditemukan di: " . $configPath);
}

// Validasi koneksi
if (!$conn) {
    die("Error: Gagal membuat koneksi database");
}

/** 1. Ambil Info Organisasi (Visi, Misi, Motto) **/
$org_result = pg_query($conn, "SELECT * FROM organization_info LIMIT 1");
$org = pg_fetch_assoc($org_result);

/** 2. Ambil Daftar Divisi **/
$div_result = pg_query($conn, "SELECT * FROM divisions ORDER BY sort_order ASC");

/** 3. Ambil Prestasi Terbaru **/
$ach_result = pg_query($conn, "SELECT * FROM achievements ORDER BY year DESC LIMIT 5");

/** 4. Hitung Statistik Dinamis dari Tabel members **/
// Total Anggota Aktif
$res_active = pg_query($conn, "SELECT COUNT(*) FROM members WHERE status_keanggotaan = 'Active'");
$total_active_members = pg_fetch_result($res_active, 0, 0);

// Generasi Terbaru (Nilai MAX)
$res_gen = pg_query($conn, "SELECT MAX(generasi) FROM members");
$max_generation = pg_fetch_result($res_gen, 0, 0) ?: 0;

// Total Kejuaraan dari Tabel achievements
$res_ach = pg_query($conn, "SELECT COUNT(*) FROM achievements");
$total_achievements = pg_fetch_result($res_ach, 0, 0);

/** 5. Cek Rekrutmen Aktif dari Tabel recruitment_periods **/
$rec_result = pg_query($conn, "SELECT * FROM recruitment_periods WHERE status = 'Active' ORDER BY tanggal_selesai DESC LIMIT 1");
$recruitment = pg_fetch_assoc($rec_result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EEPROM POLINEMA - HOME</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/home/index.css">
</head>

<body>
    <?php include __DIR__ . '/../../Views/layouts/navbar-public.php'; ?>

    <header class="hero-section" id="hero">
        <div class="container py-5 text-center">
            <div class="hero-content">
                <img src="/assets/images/eeprom_logo.png" alt="Logo EEPROM Besar" class="hero-logo">
                <h1>Electronic Education Programming Robotic Of Malang Politeknik Negeri Malang</h1>
                <p class="lead">EEPROM POLINEMA, atau Electronic Education Programming Robotic of Malang, adalah
                    komunitas yang didirikan pada tanggal 1 Juni 2011 oleh mahasiswa Jurusan Teknik Elektro Politeknik
                    Negeri Malang (Polinema). Komunitas ini merupakan tempat berkumpul bagi mahasiswa yang memiliki
                    minat di bidang robotika, khususnya robot hobbyist. Komunitas ini bertujuan sebagai wadah untuk
                    mengembangkan ilmu pengetahuan dan teknologi dalam bidang robotika, sekaligus sebagai media bagi
                    mahasiswa untuk belajar dan berinovasi.</p>
                <a href="#visi-misi" class="btn-primary-eeprom mt-3">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </header>

    <section class="visi-misi-section py-90 bg-white" id="visi-misi">
        <div class="container">
            <h2 class="section-heading">Visi & Misi Kami</h2>

            <div class="row justify-content-center mt-5">
                <div class="col-md-6 mb-4">
                    <div class="visi-misi-card h-100">
                        <div class="vm-icon-wrapper"><i class="bi bi-eye-fill"></i></div>
                        <div class="vm-content text-center">
                            <h4>Visi</h4>
                            <p><?php echo isset($org['vision']) ? htmlspecialchars($org['vision']) : 'Data visi belum tersedia.'; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="visi-misi-card h-100">
                        <div class="vm-icon-wrapper"><i class="bi bi-rocket-takeoff-fill"></i></div>
                        <div class="vm-content text-center">
                            <h4>Misi</h4>
                            <div class="misi-text">
                                <?php echo isset($org['mission']) ? nl2br(htmlspecialchars($org['mission'])) : 'Data misi belum tersedia.'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="motto-card-custom text-center">
                        <span class="motto-label">Motto Kami</span>
                        <h2 class="motto-display">
                            "<?php echo isset($org['motto']) ? htmlspecialchars($org['motto']) : 'Menang adalah Harga Mati'; ?>"
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="divisi-section py-120 bg-light-soft" id="divisi">
        <div class="container">
            <h2 class="section-heading text-center mb-5">Divisi Unggulan Kami</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
                <?php
                if ($div_result && pg_num_rows($div_result) > 0):
                    while ($div = pg_fetch_assoc($div_result)):
                        $icon = $div['icon'] ?? '📦';
                        $isImagePath = (strpos($icon, '/') !== false || strpos($icon, '.') !== false);
                        $isEmoji = preg_match('/[\x{1F300}-\x{1F9FF}]/u', $icon);

                        if ($isImagePath) {
                            $iconDisplay = '<img src="' . htmlspecialchars($icon) . '" alt="' . htmlspecialchars($div['name']) . '" style="width: 2.5rem; height: 2.5rem; object-fit: contain;">';
                        } elseif (!$isEmoji) {
                            $divisionSlug = strtolower(str_replace(' ', '_', $div['name']));
                            $defaultPath = "/assets/images/divisions/{$divisionSlug}.png";
                            $iconDisplay = '<img src="' . htmlspecialchars($defaultPath) . '" alt="' . htmlspecialchars($div['name']) . '" style="width: 2.5rem; height: 2.5rem; object-fit: contain;" onerror="this.outerHTML=\'<span style=\\\'font-size: 2.5rem;\\\'>📦</span>\'">';
                        } else {
                            $iconDisplay = '<span style="font-size: 2.5rem;">' . htmlspecialchars($icon) . '</span>';
                        }
                ?>
                        <div class="col">
                            <div class="divisi-card">
                                <div class="divisi-icon-container">
                                    <div class="icon-glow"></div>
                                    <div class="divisi-icon-wrapper">
                                        <?= $iconDisplay ?>
                                    </div>
                                </div>
                                <div class="divisi-content">
                                    <h5><?= htmlspecialchars($div['name']) ?></h5>
                                    <p><?= htmlspecialchars($div['description']) ?></p>
                                    <a href="/divisi/<?= strtolower($div['name']) ?>" class="btn-detail">
                                        <span>Detail</span> <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                else:
                    ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada data divisi tersedia.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="achievement-section py-90 bg-white" id="achievements">
        <div class="container">
            <h2 class="section-heading">Prestasi Terbaru Kami</h2>
            <div id="achievementCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#achievementCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#achievementCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                </div>
                <div class="carousel-inner pt-4">
                    <div class="carousel-item active">
                        <div class="achievement-slider-item mx-auto" style="max-width: 900px;">
                            <h4 class="text-center">RoboCup 2024 - Juara 1 Kategori Rescate Robot</h4>
                            <div class="row align-items-center">
                                <div class="col-lg-6 text-center">
                                    <i class="bi bi-trophy text-warning display-1"></i>
                                </div>
                                <div class="col-lg-6">
                                    <p class="mb-3">Tim EEPROM POLINEMA berhasil meraih Juara 1 dalam kategori Rescate Robot pada kompetisi RoboCup 2024 yang diselenggarakan di Tokyo, Jepang.</p>
                                    <ul class="achievement-list">
                                        <li>Desain robot yang inovatif dan efisien.</li>
                                        <li>Strategi penyelamatan yang efektif.</li>
                                        <li>Kerja sama tim yang solid selama kompetisi.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="achievement-slider-item mx-auto" style="max-width: 900px;">
                            <h4 class="text-center">Kontes Robot Indonesia 2024 - Juara 2 Kategori Line Follower</h4>
                            <div class="row align-items-center">
                                <div class="col-lg-6 text-center">
                                    <i class="bi bi-award text-primary display-1"></i>
                                </div>
                                <div class="col-lg-6">
                                    <p class="mb-3">Pada Kontes Robot Indonesia 2024, tim kami berhasil meraih Juara 2 dalam kategori Line Follower.</p>
                                    <ul class="achievement-list">
                                        <li>Pemrograman sensor yang presisi.</li>
                                        <li>Optimasi kecepatan dan stabilitas robot.</li>
                                        <li>Latihan intensif sebelum kompetisi.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#achievementCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#achievementCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <section class="stats-section" id="stats">
        <div class="container">
            <h2 class="section-heading text-white text-center">Anggota Kami</h2>
            <div class="row mt-5 text-center">
                <div class="col-6 col-md-3 stat-card">
                    <h2 class="counter" data-target="<?php echo $total_active_members; ?>">0</h2>
                    <p>Total Anggota Aktif</p>
                </div>
                <div class="col-6 col-md-3 stat-card">
                    <h2 class="counter" data-target="<?php echo $max_generation; ?>">0</h2>
                    <p>Generasi (Sejak <?php echo $org['established_year'] ?? '2011'; ?>)</p>
                </div>
                <div class="col-6 col-md-3 stat-card">
                    <h2 class="counter" data-target="<?php echo $total_achievements; ?>">0</h2>
                    <p>Total Kejuaraan</p>
                </div>
                <div class="col-6 col-md-3 stat-card">
                    <h2 class="counter" data-target="<?php echo $org['established_year'] ?? '2011'; ?>">0</h2>
                    <p>Tahun Berdiri</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5" id="recruitment">
        <div class="recruitment-banner text-center shadow-lg">
            <?php if ($recruitment): ?>
                <div class="row align-items-center">
                    <div class="col-lg-8 p-4 text-start">
                        <h3><?php echo htmlspecialchars($recruitment['nama_periode']); ?></h3>
                        <p class="lead text-white"><?php echo htmlspecialchars($recruitment['description']); ?></p>
                        <div class="d-flex align-items-center flex-wrap">
                            <p class="m-0 me-3 fs-5 fw-bold text-white">Berakhir pada:</p>
                            <span class="countdown-timer" id="countdown" data-end="<?php echo $recruitment['tanggal_selesai']; ?>">
                                Loading...
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 p-4 text-center">
                        <a href="/form" class="btn-secondary-eeprom">Daftar Sekarang <i class="fas fa-external-link-alt ms-1"></i></a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 p-5 text-center">
                        <div class="mb-3">
                            <i class="bi bi-clock-history text-white" style="font-size: 3.5rem;"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-3">Open Recruitment: Coming Soon!</h2>
                        <p class="lead text-white opacity-75">
                            Saat ini belum ada pendaftaran anggota baru yang dibuka.<br>
                            Pantau terus media sosial kami untuk informasi regenerasi berikutnya!
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include __DIR__ . '/../../Views/layouts/footer-public.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Counter Animation
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        const animateCounters = () => {
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const inc = target / speed;
                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target;
                    }
                };
                counter.innerText = '0';
                updateCount();
            });
        }

        const statsSection = document.getElementById('stats');
        if (statsSection) {
            const statsObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });
            statsObserver.observe(statsSection);
        }

        // Countdown Timer Dinamis
        function startCountdown() {
            const countdownElement = document.getElementById('countdown');
            if (!countdownElement) return;

            const endDateStr = countdownElement.getAttribute('data-end');
            if (!endDateStr) return;

            const targetDate = new Date(endDateStr + " 23:59:59").getTime();

            const interval = setInterval(() => {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    clearInterval(interval);
                    countdownElement.innerHTML = "Pendaftaran Ditutup";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownElement.innerHTML =
                    `${String(days).padStart(2, '0')} Hari ${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', startCountdown);
    </script>
</body>

</html>