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
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
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
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        id="adminDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>"
                            alt="Profile"
                            width="35"
                            height="35"
                            class="rounded-circle me-2"
                            style="object-fit: cover; border: 1px solid #ddd;">
                        <span class="d-none d-sm-inline text-dark fw-bold">
                            <?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="adminDropdown">
                        <li>
                            <a class="dropdown-item py-2" href="/member/profile">
                                <i class="bi bi-person me-2 text-primary"></i>Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger py-2" href="/logout">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
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
                                        <option value="D4 Teknik Elektronika">D4 Teknik Elektronika</option>
                                        <option value="D4 Teknik Informatika">D4 Teknik Informatika</option>
                                        <option value="D4 Sistem Kelistrikan">D4 Sistem Kelistrikan</option>
                                        <option value="D4 Jaringan Telekomunikasi Digital">D4 Jaringan Telekomunikasi Digital</option>
                                        <option value="D3 Teknik Elektronika">D3 Teknik Elektronika</option>
                                        <option value="D3 Teknik Telekomunikasi">D3 Teknik Telekomunikasi</option>
                                        <option value="D3 Teknik Listrik">D3 Teknik Listrik</option>
                                        <option value="D3 Teknik Mesin">D3 Teknik Mesin</option>
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
                                <?php for ($i = 1; $i <= 20; $i++): ?>
                                    <option value="<?= $i ?>">Gen <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-select" onchange="handleJabatanChange()">
                                <optgroup label="Jabatan Umum">
                                    <option value="Ketua Umum">Ketua Umum</option>
                                    <option value="Sekretaris Umum">Sekretaris Umum</option>
                                    <option value="Sekretaris 1">Sekretaris 1</option>
                                    <option value="Bendahara">Bendahara</option>
                                </optgroup>

                                <optgroup label="Jabatan Divisi">
                                    <option value="Kepala Divisi Software">Ketua Divisi Software</option>
                                    <option value="Wakil Kepala Divisi Software Internal">Wakil Kepala Divisi Software Internal</option>
                                    <option value="Wakil Kepala Divisi Software RnD">Wakil Kepala Divisi Software RnD</option>

                                    <option value="Kepala Divisi Mekanik">Ketua Divisi Mekanik</option>
                                    <option value="Wakil Kepala Divisi Mekanik Internal">Wakil Kepala Divisi Mekanik Internal</option>
                                    <option value="Wakil Kepala Divisi Mekanik RnD">Wakil Kepala Divisi Mekanik RnD</option>

                                    <option value="Kepala Divisi Elektrik">Ketua Divisi Elektrik</option>
                                    <option value="Wakil Kepala Divisi Elektrik Internal">Wakil Kepala Divisi Elektrik Internal</option>
                                    <option value="Wakil Kepala Divisi Elektrik RnD">Wakil Kepala Divisi Elektrik RnD</option>

                                    <option value="Kepala Divisi Humas">Ketua Divisi Humas</option>
                                    <option value="Wakil Kepala Divisi Humas Internal">Wakil Kepala Divisi Humas Internal</option>
                                    <option value="Wakil Kepala Divisi Humas Eksternal">Wakil Kepala Divisi Humas Eksternal</option>
                                </optgroup>

                                <optgroup label="Anggota">
                                    <option value="Anggota" selected>Anggota</option>
                                </optgroup>
                            </select>
                        </div>

                        <!-- Container Divisi (akan di-show/hide oleh JavaScript) -->
                        <div class="col-md-6" id="divisiUtamaContainer">
                            <label class="form-label small fw-bold">Divisi Utama</label>
                            <select name="divisi1" id="divisi1" class="form-select" required>
                                <option value="">Pilih Divisi</option>
                                <option value="Software">Software</option>
                                <option value="Mekanik">Mekanik</option>
                                <option value="Elektrik">Elektrik</option>
                                <option value="Humas">Humas</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="divisiTambahanContainer">
                            <label class="form-label small fw-bold">Divisi Tambahan</label>
                            <select name="divisi2" id="divisi2" class="form-select">
                                <option value="">Tidak Ada</option>
                                <option value="Humas">Humas</option>
                            </select>
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
                        <input class="form-check-input" type="checkbox" id="createAccount" name="create_account" onchange="toggleAccountSection(this)" checked>
                        <label class="form-check-label fw-bold text-primary" for="createAccount">Buatkan Akun Login?</label>
                    </div>

                    <div id="accountSection" class="mt-4 border-top pt-4">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Info:</strong> Username dan Password akan otomatis diisi dengan NIM yang sama.
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Username (Otomatis dari NIM)</label>
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
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Password (Otomatis dari NIM)</label>
                                <input type="text" id="passwordField" name="password" class="form-control bg-light" readonly placeholder="Otomatis dari NIM">
                                <small class="text-muted">Password default sama dengan NIM. Anggota dapat mengubahnya setelah login.</small>
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
        // Logika Sinkronisasi NIM ke Username dan Password
        const nimInput = document.getElementById('nimInput');
        const usernameField = document.getElementById('usernameField');
        const passwordField = document.getElementById('passwordField');
        const createAccountCheckbox = document.getElementById('createAccount');

        nimInput.addEventListener('input', function() {
            const nimValue = this.value.trim();

            // Update username dan password dengan NIM
            if (createAccountCheckbox.checked) {
                usernameField.value = nimValue;
                passwordField.value = nimValue;
            }
        });

        // Toggle Bagian Akun Login
        function toggleAccountSection(checkbox) {
            const section = document.getElementById('accountSection');
            section.style.display = checkbox.checked ? 'block' : 'none';

            // Auto-fill username dan password saat checkbox diaktifkan
            if (checkbox.checked) {
                const nimValue = nimInput.value.trim();
                usernameField.value = nimValue;
                passwordField.value = nimValue;
            } else {
                usernameField.value = '';
                passwordField.value = '';
            }
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

        function handleJabatanChange() {
            const jabatanSelect = document.getElementById('jabatan');
            const divisiUtamaContainer = document.getElementById('divisiUtamaContainer');
            const divisiTambahanContainer = document.getElementById('divisiTambahanContainer');
            const divisi1Select = document.getElementById('divisi1');
            const divisi2Select = document.getElementById('divisi2');

            const selectedJabatan = jabatanSelect.value;

            // List jabatan umum (tidak perlu divisi)
            const jabatanUmum = ['Ketua Umum', 'Sekretaris Umum', 'Sekretaris 1', 'Bendahara'];

            // Cek apakah jabatan umum
            if (jabatanUmum.includes(selectedJabatan)) {
                // Hide semua divisi
                divisiUtamaContainer.style.display = 'none';
                divisiTambahanContainer.style.display = 'none';
                divisi1Select.removeAttribute('required');
                divisi1Select.value = '';
                divisi2Select.value = '';
            }
            // Cek apakah anggota
            else if (selectedJabatan === 'Anggota') {
                // Show divisi utama + tambahan
                divisiUtamaContainer.style.display = 'block';
                divisiTambahanContainer.style.display = 'block';
                divisi1Select.setAttribute('required', 'required');
                // Aktifkan kembali divisi select
                divisi1Select.removeAttribute('readonly');
                divisi1Select.style.pointerEvents = 'auto';
                divisi1Select.style.backgroundColor = '';
            }
            // Jabatan divisi (Kepala/Wakil Kepala)
            else {
                // Show hanya divisi utama
                divisiUtamaContainer.style.display = 'block';
                divisiTambahanContainer.style.display = 'none';
                divisi2Select.value = '';

                // Auto-set divisi dari nama jabatan
                if (selectedJabatan.includes('Software')) {
                    divisi1Select.value = 'Software';
                } else if (selectedJabatan.includes('Mekanik')) {
                    divisi1Select.value = 'Mekanik';
                } else if (selectedJabatan.includes('Elektrik')) {
                    divisi1Select.value = 'Elektrik';
                } else if (selectedJabatan.includes('Humas')) {
                    divisi1Select.value = 'Humas';
                }

                // Set divisi select jadi readonly (disable tapi value tetap terkirim)
                divisi1Select.setAttribute('readonly', 'readonly');
                divisi1Select.style.pointerEvents = 'none';
                divisi1Select.style.backgroundColor = '#e9ecef';
            }
        }

        // Jalankan saat halaman load
        document.addEventListener('DOMContentLoaded', function() {
            handleJabatanChange();

            // Auto-show account section dan isi dengan NIM jika sudah ada
            toggleAccountSection(createAccountCheckbox);
        });
    </script>
    <script src="/assets/js/admin/members/index.js"></script>
</body>

</html>