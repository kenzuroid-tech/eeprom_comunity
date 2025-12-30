<?php
/**
 * File: src/Views/admin/members/create.php
 */
$adminData = $adminData ?? [];
$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($adminData['nama_lengkap'] ?? 'Admin');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin/members/create.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>
        
        <div class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold text-primary">Tambah Anggota Baru</h4>
                </div>
                
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?= $adminFotoNavbar ?>" alt="Profile" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover;">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="/member/profile"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <form id="memberForm" action="/admin/members/store" method="POST" enctype="multipart/form-data">
                <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="section-title fw-bold mb-4 border-bottom pb-2 text-primary"><i class="bi bi-person-badge me-2"></i> Data Pribadi</h5>
                    <div class="row g-4">
                        <div class="col-lg-3 text-center border-end">
                            <div class="photo-preview-box mx-auto mb-3 border rounded d-flex align-items-center justify-content-center" id="photoPreview" style="width: 150px; height: 150px; overflow: hidden;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                            <label for="foto" class="btn btn-sm btn-outline-primary">Pilih Foto</label>
                            <input type="file" id="foto" name="foto" class="d-none" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">NIM</label>
                                    <input type="text" id="nimInput" name="nim" class="form-control" placeholder="Masukkan NIM" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="name@student.polinema.ac.id" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">WhatsApp</label>
                                    <input type="tel" name="social[whatsapp]" class="form-control" placeholder="08XXXXXXXXXX">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Program Studi</label>
                                    <select name="prodi" class="form-select" required>
                                        <option value="" disabled selected>Pilih Program Studi</option>
                                        <option value="Teknik Informatika">Teknik Informatika</option>
                                        <option value="Sistem Informasi Bisnis">Sistem Informasi Bisnis</option>
                                        <option value="Teknik Elektronika">Teknik Elektronika</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="section-title fw-bold mb-4 border-bottom pb-2 text-primary"><i class="bi bi-award me-2"></i> Data Keanggotaan</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Angkatan (Tahun)</label>
                            <input type="number" name="angkatan" class="form-control" min="2000" max="2099" value="<?= date('Y') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Generasi</label>
                            <select name="generasi" class="form-select">
                                <?php for($i=1; $i<=20; $i++): ?>
                                    <option value="<?= $i ?>">Gen <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Jabatan</label>
                            <select name="jabatan" class="form-select">
                                <option value="Anggota">Anggota</option>
                                <option value="Ketua Umum">Ketua Umum</option>
                                <option value="Wakil Ketua">Wakil Ketua</option>
                                <option value="Koordinator Divisi">Koordinator Divisi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Divisi Utama</label>
                            <select name="divisi1" class="form-select" required>
                                <option value="Software">Software</option>
                                <option value="Mekanik">Mekanik</option>
                                <option value="Elektrik">Elektrik</option>
                                <option value="Humas">Humas</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Divisi Tambahan</label>
                            <select name="divisi2" class="form-select">
                                <option value="">Tidak Ada</option>
                                <option value="Humas">Humas</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold d-block">Status Keanggotaan</label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_keanggotaan" id="stActive" value="active" checked>
                                    <label class="form-check-label" for="stActive">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_keanggotaan" id="stAlumni" value="alumni">
                                    <label class="form-check-label" for="stAlumni">Alumni</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="section-title fw-bold mb-4 border-bottom pb-2 text-primary"><i class="bi bi-body-text me-2"></i> Bio & Keterampilan</h5>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Bio Singkat</label>
                        <textarea name="bio" class="form-control" rows="3" placeholder="Deskripsikan diri singkat..."></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Skills (Pisahkan dengan koma)</label>
                        <input type="text" name="skills" class="form-control" placeholder="Contoh: PHP, Arduino, Design">
                    </div>
                </div>

                <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="section-title fw-bold mb-4 border-bottom pb-2 text-primary"><i class="bi bi-share me-2"></i> Social Media</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Instagram</label>
                            <input type="text" name="social[instagram]" class="form-control" placeholder="Username IG">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">LinkedIn</label>
                            <input type="url" name="social[linkedin]" class="form-control" placeholder="URL LinkedIn">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">GitHub</label>
                            <input type="text" name="social[github]" class="form-control" placeholder="Username GitHub">
                        </div>
                    </div>
                </div>

                <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="createAccount" name="create_account" onchange="toggleAccountSection(this)">
                        <label class="form-check-label fw-bold text-primary" for="createAccount">Buatkan Akun Login?</label>
                    </div>
                    
                    <div id="accountSection" style="display: none;" class="mt-4 border-top pt-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Username</label>
                                <input type="text" id="usernameField" name="username" class="form-control bg-light" readonly placeholder="Otomatis dari NIM">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold d-block">Role Akun</label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="roleAnggota" value="anggota" checked>
                                        <label class="form-check-label" for="roleAnggota">Anggota</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="roleAdmin" value="admin">
                                        <label class="form-check-label" for="roleAdmin">Admin</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Min 8 karakter">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mb-5">
                    <a href="/admin/members" class="btn btn-light px-5 border">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 shadow">Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Logika Sinkronisasi NIM ke Username
        const nimInput = document.getElementById('nimInput');
        const usernameField = document.getElementById('usernameField');
        nimInput.addEventListener('input', function() {
            usernameField.value = this.value;
        });

        // Toggle Bagian Akun Login
        function toggleAccountSection(checkbox) {
            const section = document.getElementById('accountSection');
            section.style.display = checkbox.checked ? 'block' : 'none';
        }

        // Preview Foto Profil
        function previewImage(input) {
            const preview = document.getElementById('photoPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>