<?php

/**
 * @var array $contactInfo Data alamat, email, dan medsos dari organization_contact
 * @var array $cpList      Daftar orang yang bisa dihubungi dari contact_persons
 */
$contactInfo = $contactInfo ?? [];
$cpList = $cpList ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/contact/index.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
</head>

<body>
    <?php include __DIR__ . '/../../Views/layouts/navbar-public.php'; ?>

    <header class="page-header">
        <div class="container">
            <h1 class="fw-bold">Contact Us</h1>
            <div class="header-divider mx-auto"></div>
            <p class="mt-3 opacity-75">Ada pertanyaan atau ingin berkolaborasi? Hubungi kami sekarang.</p>
        </div>
    </header>

    <main class="container">
        <?php if (isset($_GET['status'])): ?>
            <div class="alert <?= $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show mb-5 rounded-4 shadow-sm" role="alert">
                <i class="bi <?= $_GET['status'] === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?> me-2"></i>
                <?= $_GET['status'] === 'success' ? '<strong>Berhasil!</strong> Pesan Anda telah terkirim.' : '<strong>Gagal!</strong> Terjadi kesalahan mengirim pesan.' ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4 mb-100">
            <div class="col-md-4">
                <div class="info-card text-center h-100">
                    <div class="info-icon-wrapper"><i class="bi bi-geo-alt"></i></div>
                    <h4 class="fw-bold text-dark">Sekretariat</h4>
                    <p class="text-muted small"><?= htmlspecialchars($contactInfo['address'] ?? 'Jl. Soekarno Hatta No.9, Malang.') ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card text-center h-100">
                    <div class="info-icon-wrapper"><i class="bi bi-envelope"></i></div>
                    <h4 class="fw-bold text-dark">Email Resmi</h4>
                    <p class="text-muted small"><?= htmlspecialchars($contactInfo['email'] ?? 'eeprom.polinema@gmail.com') ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card text-center h-100">
                    <div class="info-icon-wrapper"><i class="bi bi-share"></i></div>
                    <h4 class="fw-bold text-dark">Media Sosial</h4>
                    <div class="d-flex justify-content-center gap-3 mt-2">
                        <a href="<?= $contactInfo['instagram'] ?? 'https://www.instagram.com/eeprom.polinema/' ?>" class="social-link-item inst" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link-item yt"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-link-item lnk"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5 align-items-stretch mb-5">
            <div class="col-lg-7">
                <div class="section-title-wrapper mb-4">
                    <h3 class="fw-bold text-primary">Lokasi Kami</h3>
                    <div class="title-line"></div>
                </div>
                <div id="map-frame" class="map-container overflow-hidden rounded-4 shadow-sm" style="height: 450px; border: 5px solid white;">
                    <?php if (!empty($contactInfo['maps_code'])): ?>
                        <?= $contactInfo['maps_code'] ?>
                    <?php else: ?>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.447514118334!2d112.61234477464047!3d-7.952601779234854!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7882793db47ad7%3A0x869957f7f4ec8059!2sEEPROM%20Polinema!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    <?php endif; ?>
                </div>
                <div class="mt-3">
                    <button onclick="openMaps()" class="btn btn-outline-primary rounded-pill px-4 btn-sm fw-bold">
                        <i class="bi bi-map me-2"></i>Buka di Google Maps
                    </button>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="contact-form-container h-100 shadow-sm border rounded-4 p-4 bg-white">
                    <h3 class="mb-4 fw-bold text-primary">Kirim Pesan</h3>
                    <form action="/contact/submit" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control rounded-4" id="floatingName" placeholder="Nama Lengkap" required>
                            <label for="floatingName">Nama Lengkap</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control rounded-4" id="floatingEmail" placeholder="Alamat Email" required>
                            <label for="floatingEmail">Alamat Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="subject" class="form-control rounded-4" id="floatingSubject" placeholder="Subjek" required>
                            <label for="floatingSubject">Subjek</label>
                        </div>
                        <div class="form-floating mb-4">
                            <textarea name="message" class="form-control rounded-4" id="floatingMsg" style="height: 150px" placeholder="Pesan Anda..." required></textarea>
                            <label for="floatingMsg">Pesan Anda...</label>
                        </div>
                        <button type="submit" class="btn btn-primary-eeprom w-100 py-3 rounded-pill fw-bold">
                            Kirim Pesan <i class="bi bi-send-fill ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <section class="mt-5 py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Contact Person</h2>
                <p class="text-muted">Hubungi tim kami secara langsung melalui WhatsApp</p>
            </div>
            <div class="row g-4 justify-content-center">
                <?php if (empty($cpList)): ?>
                    <p class="text-center text-muted">Belum ada data Contact Person.</p>
                <?php else: ?>
                    <?php foreach ($cpList as $cp): ?>
                        <div class="col-md-4">
                            <div class="cp-card h-100 shadow-sm border-0">
                                <div class="cp-img-wrapper">
                                    <img src="<?= $cp['photo_url'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($cp['name']) . '&background=1A237E&color=fff' ?>"
                                        alt="<?= htmlspecialchars($cp['name']) ?>">
                                </div>
                                <h5 class="fw-bold mb-1"><?= htmlspecialchars($cp['name']) ?></h5>
                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1 mb-3 small fw-bold">
                                    <?= htmlspecialchars($cp['position'] ?? 'Staf') ?>
                                </span>
                                <p class="small text-muted mb-4"><i class="bi bi-envelope-fill me-2 text-primary"></i><?= htmlspecialchars($cp['email'] ?? '-') ?></p>
                                <a href="https://wa.me/6282331773806<?= preg_replace('/[^0-9]/', '', $cp['phone'] ?? '') ?>" target="_blank" class="btn-whatsapp">
                                    <i class="fab fa-whatsapp me-2"></i>Hubungi WhatsApp
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/../../Views/layouts/footer-public.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Efek Scroll Navbar
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar-eeprom');
            if (window.scrollY > 50) {
                nav.style.background = 'rgba(255, 255, 255, 0.95)';
                nav.style.top = '10px';
            } else {
                nav.style.background = 'rgba(255, 255, 255, 0.8)';
                nav.style.top = '20px';
            }
        });

        // Konfigurasi API Lokasi
        const locationAPI = {
            name: "EEPROM Polinema",
            address: "Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141, Indonesia",
            placeId: "ChIJbXrUPQCDeC4RWYDs9PdXmYY",
            coords: {
                lat: -7.9453032,
                lng: 112.6145107
            }
        };

        // Membuka Google Maps di tab baru
        function openMaps() {
            const url = `https://www.google.com/maps/search/?api=1&query=${locationAPI.coords.lat},${locationAPI.coords.lng}`;
            window.open(url, '_blank');
        }
    </script>
</body>

</html>