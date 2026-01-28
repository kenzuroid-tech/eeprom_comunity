<?php

/**
 * Logika tambahan untuk Jabatan vs Divisi
 */
$jabatan = $member['jabatan'] ?? 'Anggota';
$jabatanInti = ['Ketua Umum', 'Sekretaris Umum', 'Sekretaris 1', 'Bendahara Umum'];

// Jika pengurus inti, tampilkan Jabatan. Jika anggota biasa, tampilkan Divisi.
if (in_array($jabatan, $jabatanInti)) {
    $displayRole = $jabatan;
    $roleLabel = "Jabatan";
} else {
    $displayRole = $member['divisi'] ?? '-';
    $roleLabel = "Divisi";
}

// Decode Social Links
$social = json_decode($member['social_links'] ?? '{}', true);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($member['nama_lengkap']) ?> - Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">

    <style>
        :root {
            --primary-blue: #1A237E;
            --secondary-blue: #3F51B5;
            --accent-orange: #FF5722;
            --light-gray: #F8F9FA;
            --dark-text: #1E293B;
            --soft-text: #64748B;
        }

        body {
            background-color: var(--light-gray);
            font-family: 'Poppins', sans-serif;
            color: var(--soft-text);
        }

        /* --- Header Profile --- */
        .profile-header-bg {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            height: 350px;
            border-radius: 0 0 50px 50px;
            position: relative;
            margin-bottom: 180px;
            padding-top: 40px;
        }

        .back-btn-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 100;
        }

        .profile-main-card {
            position: absolute;
            top: 180px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 850px;
            background: white;
            border-radius: 30px;
            padding: 40px 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 10;
        }

        .profile-avatar-wrapper {
            width: 150px;
            height: 150px;
            margin: -115px auto 20px;
            border-radius: 50%;
            padding: 5px;
            background: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .profile-avatar-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .member-name {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-blue);
            margin-bottom: 5px;
        }

        .badge-status-profile {
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 15px;
            display: inline-block;
        }

        .status-active {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-alumni {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* --- Mini Stats Grid --- */
        .mini-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 25px;
        }

        .mini-stat-box {
            background: #F8FAFC;
            padding: 12px;
            border-radius: 15px;
            border: 1px solid #E2E8F0;
        }

        /* --- Content Layout --- */
        .info-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--accent-orange);
        }

        .detail-label {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #94A3B8;
            display: block;
            margin-bottom: 2px;
        }

        .detail-value {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 15px;
            display: block;
            font-size: 0.9rem;
        }

        .skill-badge {
            background: #F1F5F9;
            color: var(--primary-blue);
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid #E2E8F0;
        }

        .social-link-profile {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: var(--light-gray);
            color: var(--primary-blue);
            transition: 0.3s;
            text-decoration: none;
        }

        .social-link-profile:hover {
            background: var(--primary-blue);
            color: white;
        }

        .footer-profile {
            background-color: var(--primary-blue);
            color: white;
            padding: 40px 0;
            border-radius: 50px 50px 0 0;
            margin-top: 80px;
        }

        @media (max-width: 991px) {
            .profile-header-bg {
                margin-bottom: 380px;
            }

            .mini-stats-grid {
                grid-template-columns: 1fr;
            }

            .profile-main-card {
                top: 150px;
            }
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../../Views/layouts/navbar-public.php'; ?>

    <div class="profile-header-bg">
        <div class="back-btn-container">
            <a href="/member" class="btn btn-sm btn-light rounded-pill px-4 shadow-sm fw-bold text-primary">
                <i class="bi bi-arrow-left me-1"></i> Back to Members
            </a>
        </div>

        <div class="profile-main-card shadow">
            <div class="profile-avatar-wrapper">
                <img src="<?= $member['foto_url'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($member['nama_lengkap']) . '&background=1A237E&color=fff' ?>"
                    alt="Profile" onerror="this.src='/assets/images/eeprom_logo.png'">
            </div>

            <div class="badge-status-profile <?= strtolower($member['status_keanggotaan']) == 'active' ? 'status-active' : 'status-alumni' ?>">
                <?= htmlspecialchars($member['status_keanggotaan']) ?> Member
            </div>

            <h1 class="member-name text-truncate px-3"><?= htmlspecialchars($member['nama_lengkap']) ?></h1>
            <p class="small fw-bold text-muted">NIM. <?= htmlspecialchars($member['nim']) ?></p>

            <div class="mini-stats-grid">
                <div class="mini-stat-box">
                    <span class="detail-label"><?= $roleLabel ?></span>
                    <span class="detail-value text-primary m-0 small"><?= htmlspecialchars($displayRole) ?></span>
                </div>
                <div class="mini-stat-box">
                    <span class="detail-label">Generasi</span>
                    <span class="detail-value text-primary m-0 small">Gen <?= htmlspecialchars($member['generasi']) ?></span>
                </div>
                <div class="mini-stat-box">
                    <span class="detail-label">Angkatan</span>
                    <span class="detail-value text-primary m-0 small"><?= htmlspecialchars($member['angkatan'] ?? '-') ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5" style="max-width: 1100px;">
        <div class="row g-4 d-flex align-items-stretch">

            <div class="col-lg-3">
                <div class="info-card">
                    <h3 class="section-title"><i class="bi bi-person-lines-fill"></i> Koneksi </h3>

                    <span class="detail-label">Email Address</span>
                    <span class="detail-value text-break small"><?= htmlspecialchars($member['email'] ?? '-') ?></span>

                    <span class="detail-label">Social Media</span>
                    <div class="d-flex gap-2">
                        <?php if (!empty($social['instagram'])): ?>
                            <a href="https://instagram.com/<?= $social['instagram'] ?>" class="social-link-profile"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($social['whatsapp'])): ?>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $social['whatsapp']) ?>" class="social-link-profile"><i class="fab fa-whatsapp"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="info-card">
                    <h3 class="section-title"><i class="bi bi-chat-left-quote"></i> Bio</h3>
                    <p class="text-dark small mb-0" style="text-align: justify; line-height: 1.6;">
                        <?= nl2br(htmlspecialchars($member['bio'] ?: 'Anggota ini belum menuliskan deskripsi diri.')) ?>
                    </p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="info-card">
                    <h3 class="section-title"><i class="bi bi-cpu"></i> Skill</h3>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        if (!empty($member['skills'])) {
                            $skills = explode(',', $member['skills']);
                            foreach ($skills as $skill) {
                                if (trim($skill) != '') echo '<span class="skill-badge">' . htmlspecialchars(trim($skill)) . '</span>';
                            }
                        } else {
                            echo '<p class="small text-muted mb-0">Belum ada skill yang ditambahkan.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="footer-profile text-center">
        <div class="container">
            <img src="/assets/images/eeprom_logo.png" alt="Logo" width="40" class="mb-3">
            <h6 class="fw-bold m-0 small">EEPROM POLINEMA</h6>
            <p class="small opacity-50 mt-2" style="font-size: 0.7rem;">&copy; 2026 EEPROM POLINEMA. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>