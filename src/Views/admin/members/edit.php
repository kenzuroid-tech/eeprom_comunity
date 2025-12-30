<?php

/**
 * File: src/Views/admin/members/edit.php
 */
$adminData = $adminData ?? [];
$member = $member ?? null;

if (!$member) {
    echo "Data anggota tidak ditemukan.";
    exit;
}

// Decode social links dari JSONB database
$social = json_decode($member['social_links'] ?? '{}', true);

$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($adminData['nama_lengkap'] ?? 'Admin');
$memberAvatar = !empty($member['foto_url']) ? $member['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($member['nama_lengkap']) . '&background=3F51B5&color=fff';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Edit Data Anggota</h4>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?= $adminFotoNavbar ?>" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover;">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="/member/profile"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="mb-4">
                <a href="/admin/members" class="btn btn-outline-secondary btn-sm rounded-pill"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>

            <form action="/admin/members/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?= $member['user_id'] ?>">

                <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                    <div class="fw-bold mb-4 border-bottom pb-2 text-primary">
                        <i class="bi bi-person-vcard me-2"></i> Informasi Pribadi
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-3 text-center border-end">
                            <div class="mb-3">
                                <img src="<?= $memberAvatar ?>" alt="Avatar" class="rounded-circle shadow" width="150" height="150" style="object-fit: cover;">
                            </div>
                            <label class="btn btn-sm btn-outline-primary mb-2">
                                <i class="bi bi-camera me-1"></i> Ganti Foto
                                <input type="file" name="photo" hidden accept="image/*">
                            </label>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" value="<?= htmlspecialchars($member['nama_lengkap']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">NIM</label>
                                    <input type="text" class="form-control" name="nim" value="<?= htmlspecialchars($member['nim']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($member['email']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Program Studi</label>
                                    <select class="form-select" name="prodi">
                                        <option value="Teknik Informatika" <?= ($member['prodi'] == 'Teknik Informatika') ? 'selected' : '' ?>>Teknik Informatika</option>
                                        <option value="Sistem Informasi Bisnis" <?= ($member['prodi'] == 'Sistem Informasi Bisnis') ? 'selected' : '' ?>>Sistem Informasi Bisnis</option>
                                        <option value="Teknik Elektronika" <?= ($member['prodi'] == 'Teknik Elektronika') ? 'selected' : '' ?>>Teknik Elektronika</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fw-bold mt-5 mb-4 border-bottom pb-2 text-primary">
                        <i class="bi bi-diagram-3 me-2"></i> Detail Organisasi
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Angkatan</label>
                            <input type="number" class="form-control" name="angkatan" value="<?= htmlspecialchars($member['angkatan'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Generasi</label>
                            <input type="number" class="form-control" name="generasi" value="<?= htmlspecialchars($member['generasi'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Jabatan</label>
                            <select class="form-select" name="jabatan">
                                <option value="Anggota" <?= ($member['jabatan'] == 'Anggota') ? 'selected' : '' ?>>Anggota</option>
                                <option value="Ketua Umum" <?= ($member['jabatan'] == 'Ketua Umum') ? 'selected' : '' ?>>Ketua Umum</option>
                                <option value="Wakil Ketua" <?= ($member['jabatan'] == 'Wakil Ketua') ? 'selected' : '' ?>>Wakil Ketua</option>
                                <option value="Koordinator Divisi" <?= ($member['jabatan'] == 'Koordinator Divisi') ? 'selected' : '' ?>>Koordinator Divisi</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Divisi Utama</label>
                            <select name="divisi1" class="form-select">
                                <option value="Software" <?= (strpos($member['divisi'] ?? '', 'Software') !== false) ? 'selected' : '' ?>>Software</option>
                                <option value="Mekanik" <?= (strpos($member['divisi'] ?? '', 'Mekanik') !== false) ? 'selected' : '' ?>>Mekanik</option>
                                <option value="Elektrik" <?= (strpos($member['divisi'] ?? '', 'Elektrik') !== false) ? 'selected' : '' ?>>Elektrik</option>
                                <option value="Humas" <?= ($member['divisi'] === 'Humas') ? 'selected' : '' ?>>Humas</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Divisi Tambahan</label>
                            <select name="divisi2" class="form-select">
                                <option value="">Tidak Ada</option>
                                <option value="Humas" <?= (strpos($member['divisi'] ?? '', ', Humas') !== false) ? 'selected' : '' ?>>Humas</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold small d-block">Status Keanggotaan</label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_keanggotaan" id="stActive" value="active" <?= ($member['status_keanggotaan'] !== 'alumni') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="stActive">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_keanggotaan" id="stAlumni" value="alumni" <?= ($member['status_keanggotaan'] == 'alumni') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="stAlumni">Alumni</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fw-bold mt-5 mb-4 border-bottom pb-2 text-primary">
                        <i class="bi bi-journal-text me-2"></i> Bio & Keterampilan
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Bio Singkat</label>
                        <textarea class="form-control" name="bio" rows="3"><?= htmlspecialchars($member['bio'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Keterampilan (Pisahkan dengan koma)</label>
                        <input type="text" class="form-control" name="skills" value="<?= htmlspecialchars($member['skills'] ?? '') ?>" placeholder="Python, Arduino, PCB Design">
                    </div>

                    <div class="fw-bold mt-5 mb-4 border-bottom pb-2 text-primary">
                        <i class="bi bi-share me-2"></i> Social Media (URL / Username)
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">WhatsApp</label>
                            <input type="text" class="form-control" name="social[whatsapp]" value="<?= htmlspecialchars($social['whatsapp'] ?? '') ?>" placeholder="0812...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Instagram</label>
                            <input type="text" class="form-control" name="social[instagram]" value="<?= htmlspecialchars($social['instagram'] ?? '') ?>" placeholder="Username IG">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">LinkedIn</label>
                            <input type="url" class="form-control" name="social[linkedin]" value="<?= htmlspecialchars($social['linkedin'] ?? '') ?>" placeholder="URL LinkedIn">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">GitHub</label>
                            <input type="text" class="form-control" name="social[github]" value="<?= htmlspecialchars($social['github'] ?? '') ?>" placeholder="Username GitHub">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-5">
                    <button type="button" class="btn btn-outline-danger px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i> Hapus Anggota
                    </button>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-5 shadow">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p>Hapus <strong><?= htmlspecialchars($member['nama_lengkap']) ?></strong> secara permanen?</p>
                </div>
                <div class="modal-footer">
                    <form action="/admin/members/delete" method="POST">
                        <input type="hidden" name="user_id" value="<?= $member['user_id'] ?>">
                        <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>