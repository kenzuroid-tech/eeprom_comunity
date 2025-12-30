<?php

/**
 * File: src/Views/member-area/profile/index.php
 */

$profileData = $profileData ?? [];
$socialLinks = json_decode($profileData['social_links'] ?? '{}', true);

// Gunakan foto_url sesuai skema database PostgreSQL Anda
$fotoPath = !empty($profileData['foto_url']) ? $profileData['foto_url'] : '/assets/images/memeng.jpg';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/member-area/profile/index.css">
    <style>
        .info-label {
            color: #6c757d;
            font-size: 0.85rem;
            margin-bottom: 2px;
            font-weight: 500;
        }

        .info-value {
            color: #212529;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .profile-avatar {
            border: 4px solid #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .widget-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold text-dark">Profil Saya</h4>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?= $fotoPath ?>" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover;">
                        <span class="d-none d-sm-inline text-dark fw-bold small"><?= htmlspecialchars($profileData['nama_lengkap'] ?? 'Member') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item" href="/member/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="widget-card">
                <ul class="nav nav-tabs nav-tabs-custom mb-4" id="profileTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active fw-bold" id="view-tab" data-bs-toggle="tab" data-bs-target="#view-content" type="button" role="tab">View Profile</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit-content" type="button" role="tab">Edit Profile</button>
                    </li>
                </ul>

                <div class="tab-content" id="profileTabContent">
                    <div class="tab-pane fade show active" id="view-content" role="tabpanel">
                        <div class="row">
                            <div class="col-md-3 text-center border-end">
                                <img src="<?= $fotoPath ?>" class="profile-avatar mb-3" style="width: 160px; height: 160px; object-fit: cover; border-radius: 50%;">
                                <h5 class="fw-bold mb-1"><?= htmlspecialchars($profileData['nama_lengkap'] ?? '-') ?></h5>
                                <p class="text-muted small mb-2"><?= htmlspecialchars($profileData['nim'] ?? '-') ?></p>
                                <span class="badge bg-primary px-3 rounded-pill"><?= htmlspecialchars($profileData['jabatan'] ?? 'Anggota') ?></span>
                            </div>

                            <div class="col-md-9 ps-md-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="info-label">Program Studi</p>
                                        <p class="info-value"><?= htmlspecialchars($profileData['prodi'] ?? '-') ?></p>
                                        <p class="info-label">Angkatan</p>
                                        <p class="info-value">20<?= htmlspecialchars($profileData['angkatan'] ?? '-') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="info-label">Divisi</p>
                                        <p class="info-value"><?= htmlspecialchars($profileData['divisi'] ?? '-') ?></p>
                                        <p class="info-label">Email</p>
                                        <p class="info-value"><?= htmlspecialchars($profileData['email'] ?? '-') ?></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="info-label">Bio</p>
                                        <p class="info-value text-muted italic">"<?= htmlspecialchars($profileData['bio'] ?? 'Halo! Saya anggota EEPROM.') ?>"</p>
                                    </div>
                                </div>
                                <hr>
                                <h6 class="fw-bold mb-3 small text-uppercase text-primary">Skills</h6>
                                <div>
                                    <?php
                                    $skills = explode(',', $profileData['skills'] ?? '');
                                    foreach ($skills as $skill): if (trim($skill)): ?>
                                            <span class="badge bg-light text-dark border me-1 mb-1 p-2"><?= htmlspecialchars(trim($skill)) ?></span>
                                    <?php endif;
                                    endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="edit-content" role="tabpanel">
                        <form action="/member/profile/update" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="old_foto" value="<?= htmlspecialchars($profileData['foto_url'] ?? '') ?>">

                            <div class="row g-4">
                                <div class="col-md-3 text-center">
                                    <label class="form-label fw-bold d-block">Foto Profil</label>
                                    <img id="imgPreview" src="<?= $fotoPath ?>" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 2px solid #ddd;">
                                    <input type="file" name="foto" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this)">
                                </div>

                                <div class="col-md-9">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Bio</label>
                                            <textarea name="bio" class="form-control" rows="3"><?= htmlspecialchars($profileData['bio'] ?? '') ?></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Divisi Utama</label>
                                            <select name="divisi1" class="form-select">
                                                <option value="Software" <?= (strpos($profileData['divisi'] ?? '', 'Software') !== false) ? 'selected' : '' ?>>Software</option>
                                                <option value="Mekanik" <?= (strpos($profileData['divisi'] ?? '', 'Mekanik') !== false) ? 'selected' : '' ?>>Mekanik</option>
                                                <option value="Elektro" <?= (strpos($profileData['divisi'] ?? '', 'Elektro') !== false) ? 'selected' : '' ?>>Elektro</option>
                                                <option value="Humas" <?= ($profileData['divisi'] ?? '' === 'Humas') ? 'selected' : '' ?>>Humas</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Divisi Tambahan</label>
                                            <select name="divisi2" class="form-select">
                                                <option value="">Tidak Ada</option>
                                                <option value="Humas" <?= (strpos($profileData['divisi'] ?? '', ', Humas') !== false) ? 'selected' : '' ?>>Humas</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Skills (Pisahkan dengan koma)</label>
                                            <input type="text" name="skills" class="form-control" value="<?= htmlspecialchars($profileData['skills'] ?? '') ?>" placeholder="PHP, IoT, Design">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">GitHub</label>
                                            <input type="text" name="github" class="form-control" value="<?= htmlspecialchars($socialLinks['github'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Instagram</label>
                                            <input type="text" name="instagram" class="form-control" value="<?= htmlspecialchars($socialLinks['instagram'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">WhatsApp</label>
                                            <input type="text" name="whatsapp" class="form-control" value="<?= htmlspecialchars($socialLinks['whatsapp'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary px-5 fw-bold">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imgPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>