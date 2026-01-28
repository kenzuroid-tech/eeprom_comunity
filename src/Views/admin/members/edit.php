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

// 1. Logika Pecah Divisi (Database: "Software, Humas" -> Utama: Software, Tambahan: Humas)
$divisiArr = explode(', ', $member['divisi'] ?? '');
$divisiUtama = $divisiArr[0] ?? '';
$divisiTambahan = $divisiArr[1] ?? '';

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

        <main id="mainContentWrapper" class="admin-main-content">
            <nav class="navbar-top-admin shadow-sm mb-4 px-4 py-3 d-flex justify-content-between align-items-center bg-white rounded-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-primary border-0 me-3 d-lg-none" onclick="toggleSidebar()">
                        <i class="bi bi-list fs-3"></i>
                    </button>
                    <h4 class="m-0 fw-bold text-dark">Edit Data: <?= htmlspecialchars($member['nama_lengkap']) ?></h4>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle user-nav" data-bs-toggle="dropdown">
                        <img src="<?= $adminFotoNavbar ?>" width="35" height="35" class="rounded-circle border me-lg-2" style="object-fit: cover;">
                        <span class="d-none d-lg-inline text-dark fw-bold small"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-4">
                        <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="mb-4">
                <a href="/admin/members" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            <form action="/admin/members/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="member_id" value="<?= $member['id'] ?>">
                <input type="hidden" name="user_id" value="<?= $member['user_id'] ?>">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="admin-widget-card bg-white p-4 rounded-4 shadow-sm mb-4 text-center">
                            <div class="mb-4">
                                <img src="<?= $memberAvatar ?>" id="previewImg" alt="Avatar" class="rounded-circle shadow-sm border border-4 border-white" width="180" height="180" style="object-fit: cover;">
                            </div>
                            <label class="btn btn-primary rounded-pill px-4 btn-sm mb-3">
                                <i class="bi bi-camera me-2"></i>Ganti Foto Profil
                                <input type="file" name="foto" id="fotoInput" hidden accept="image/*">
                            </label>
                            <p class="text-muted small">Disarankan rasio 1:1, Maksimal 2MB</p>

                            <hr class="my-4 opacity-50">

                            <div class="text-start">
                                <label class="form-label fw-bold small text-primary">Bio Singkat</label>
                                <textarea class="form-control rounded-3" name="bio" rows="4" placeholder="Tulis bio singkat..."><?= htmlspecialchars($member['bio'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="admin-widget-card bg-white p-4 rounded-4 shadow-sm mb-4">
                            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2"><i class="bi bi-person-lines-fill me-2"></i>Identitas & Akun</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Nama Lengkap</label>
                                    <input type="text" class="form-control rounded-3" name="nama_lengkap" value="<?= htmlspecialchars($member['nama_lengkap']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">NIM</label>
                                    <input type="text" class="form-control rounded-3" name="nim" value="<?= htmlspecialchars($member['nim']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Email Akun</label>
                                    <input type="email" class="form-control rounded-3" name="email" value="<?= htmlspecialchars($member['account_email'] ?? $member['email']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Hak Akses (Role)</label>
                                    <?php if ($_SESSION['role'] === 'superadmin'): ?>
                                        <select name="role" class="form-select rounded-3 border-warning">
                                            <option value="anggota" <?= ($member['role'] == 'anggota') ? 'selected' : '' ?>>Anggota</option>
                                            <option value="admin" <?= ($member['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                                            <option value="alumni" <?= ($member['role'] == 'alumni') ? 'selected' : '' ?>>Alumni</option>
                                            <option value="superadmin" <?= ($member['role'] == 'superadmin') ? 'selected' : '' ?>>Superadmin</option>
                                        </select>
                                    <?php else: ?>
                                        <input type="text" class="form-control bg-light rounded-3" value="<?= ucfirst($member['role'] ?? 'anggota') ?>" readonly>
                                        <input type="hidden" name="role" value="<?= $member['role'] ?? 'anggota' ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="admin-widget-card bg-white p-4 rounded-4 shadow-sm mb-4">
                            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2"><i class="bi bi-briefcase-fill me-2"></i>Data Organisasi</h5>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small">Angkatan</label>
                                    <input type="number" class="form-control rounded-3" name="angkatan" value="<?= htmlspecialchars($member['angkatan']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small">Generasi</label>
                                    <input type="number" class="form-control rounded-3" name="generasi" value="<?= htmlspecialchars($member['generasi']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small">Status</label>
                                    <select name="status_keanggotaan" class="form-select rounded-3">
                                        <option value="Active" <?= ($member['status_keanggotaan'] == 'Active') ? 'selected' : '' ?>>Active</option>
                                        <option value="Alumni" <?= ($member['status_keanggotaan'] == 'Alumni') ? 'selected' : '' ?>>Alumni</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Jabatan Utama</label>
                                    <select name="jabatan" id="jabatan" class="form-select rounded-3" onchange="handleJabatanChange()">
                                        <optgroup label="Pengurus Inti">
                                            <option value="Ketua Umum" <?= ($member['jabatan'] == 'Ketua Umum') ? 'selected' : '' ?>>Ketua Umum</option>
                                            <option value="Sekretaris Umum" <?= ($member['jabatan'] == 'Sekretaris Umum') ? 'selected' : '' ?>>Sekretaris Umum</option>
                                            <option value="BendaharaUmum" <?= ($member['jabatan'] == 'BendaharaUmum') ? 'selected' : '' ?>>Bendahara Umum</option>
                                        </optgroup>
                                        <optgroup label="Pimpinan Divisi">
                                            <option value="Kepala Divisi Software" <?= ($member['jabatan'] == 'Kepala Divisi Software') ? 'selected' : '' ?>>Kepala Divisi Software</option>
                                            <option value="Kepala Divisi Mekanik" <?= ($member['jabatan'] == 'Kepala Divisi Mekanik') ? 'selected' : '' ?>>Kepala Divisi Mekanik</option>
                                            <option value="Kepala Divisi Elektrik" <?= ($member['jabatan'] == 'Kepala Divisi Elektrik') ? 'selected' : '' ?>>Kepala Divisi Elektrik</option>
                                            <option value="Kepala Divisi Humas" <?= ($member['jabatan'] == 'Kepala Divisi Humas') ? 'selected' : '' ?>>Kepala Divisi Humas</option>
                                        </optgroup>
                                        <optgroup label="Anggota">
                                            <option value="Anggota" <?= ($member['jabatan'] == 'Anggota') ? 'selected' : '' ?>>Anggota</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="col-md-6" id="divisiUtamaContainer">
                                    <label class="form-label fw-bold small text-success">Divisi Utama</label>
                                    <select name="divisi1" id="divisi1" class="form-select rounded-3">
                                        <option value="">-- Pilih --</option>
                                        <option value="Software" <?= ($divisiUtama == 'Software') ? 'selected' : '' ?>>Software</option>
                                        <option value="Mekanik" <?= ($divisiUtama == 'Mekanik') ? 'selected' : '' ?>>Mekanik</option>
                                        <option value="Elektrik" <?= ($divisiUtama == 'Elektrik') ? 'selected' : '' ?>>Elektrik</option>
                                        <option value="Humas" <?= ($divisiUtama == 'Humas') ? 'selected' : '' ?>>Humas</option>
                                    </select>
                                </div>

                                <div class="col-md-6" id="divisiTambahanContainer">
                                    <label class="form-label fw-bold small text-info">Divisi Tambahan (Opsional)</label>
                                    <select name="divisi2" id="divisi2" class="form-select rounded-3">
                                        <option value="">Tidak Ada</option>
                                        <option value="Humas" <?= ($divisiTambahan == 'Humas') ? 'selected' : '' ?>>Humas</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="admin-widget-card bg-white p-4 rounded-4 shadow-sm mb-4">
                            <h5 class="fw-bold mb-4 text-primary border-bottom pb-2"><i class="bi bi-share-fill me-2"></i>Social Media</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light rounded-start-3"><i class="bi bi-whatsapp text-success"></i></span>
                                        <input type="text" class="form-control" name="social[whatsapp]" placeholder="08..." value="<?= htmlspecialchars($social['whatsapp'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light rounded-start-3"><i class="bi bi-instagram text-danger"></i></span>
                                        <input type="text" class="form-control" name="social[instagram]" placeholder="Username IG" value="<?= htmlspecialchars($social['instagram'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mb-5">
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow fw-bold">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <?php if ($_SESSION['role'] === 'superadmin'): ?>
        <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="/admin/members/reset-password" method="POST" class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header bg-warning rounded-top-4 py-3">
                        <h5 class="modal-title fw-bold text-dark"><i class="bi bi-shield-lock me-2"></i>Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="user_id" value="<?= $member['user_id'] ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Baru</label>
                            <input type="text" name="new_password" class="form-control rounded-3" required placeholder="Masukkan password baru...">
                        </div>
                        <div class="alert alert-warning small border-0 mb-0">
                            <i class="bi bi-info-circle me-2"></i>Password akan langsung terganti di sistem.
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning fw-bold rounded-pill">Update Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview Foto Profil Saat Upload
        document.getElementById('fotoInput').addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
            }
            if (this.files[0]) reader.readAsDataURL(this.files[0]);
        });

        // Logika Dinamis Dropdown Divisi Berdasarkan Jabatan
        function handleJabatanChange() {
            const jabatan = document.getElementById('jabatan').value;
            const containerTambahan = document.getElementById('divisiTambahanContainer');
            const containerUtama = document.getElementById('divisiUtamaContainer');
            const d1 = document.getElementById('divisi1');
            const d2 = document.getElementById('divisi2');

            const jabatanInti = ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum'];

            if (jabatanInti.includes(jabatan)) {
                // Jabatan inti tidak butuh divisi
                containerUtama.style.display = 'none';
                containerTambahan.style.display = 'none';
                d1.value = '';
                d2.value = '';
            } else if (jabatan === 'Anggota') {
                // Anggota bisa pilih divisi utama & tambahan
                containerUtama.style.display = 'block';
                containerTambahan.style.display = 'block';
                d1.disabled = false;
                d1.style.backgroundColor = 'white';
            } else {
                // Kepala/Wakil Kepala Divisi -> Kunci divisi utama sesuai nama jabatannya
                containerUtama.style.display = 'block';
                containerTambahan.style.display = 'none';
                d2.value = '';

                if (jabatan.includes('Software')) d1.value = 'Software';
                else if (jabatan.includes('Mekanik')) d1.value = 'Mekanik';
                else if (jabatan.includes('Elektrik')) d1.value = 'Elektrik';
                else if (jabatan.includes('Humas')) d1.value = 'Humas';

                // Buat readonly visual
                d1.disabled = false; // Biar value tetap terkirim saat POST
            }
        }

        // Jalankan fungsi sekali saat halaman baru dibuka
        document.addEventListener('DOMContentLoaded', handleJabatanChange);
    </script>
</body>

</html>