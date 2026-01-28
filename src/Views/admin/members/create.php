<?php

/**
 * File: src/Views/admin/members/create.php
 */
$adminData = $adminData ?? [];
$adminFotoNavbar = !empty($adminData['foto_url'])
    ? $adminData['foto_url']
    : 'https://ui-avatars.com/api/?name=' . urlencode($adminData['nama_lengkap'] ?? 'Admin') . '&background=1A237E&color=fff';
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
    <link rel="stylesheet" href="/assets/css/admin/members/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <main id="mainContentWrapper" class="admin-main-content">
            <?php include_once __DIR__ . '/../includes/header.php'; ?>

            <form id="memberForm" action="/admin/members/store" method="POST" enctype="multipart/form-data">
                <div class="admin-widget-card bg-white p-4 rounded-4 shadow-sm mb-4">
                    <h5 class = "section-title fw-bold mb-4 border-bottom pb-3 text-primary"><i class="bi bi-person-badge me-2"></i> Data Pribadi</h5>
                    <div class="row g-4">
                        <div class="col-lg-3 text-center border-end-lg">
                            <div class="photo-preview-box mx-auto mb-3 border rounded-circle d-flex align-items-center justify-content-center shadow-sm" id="photoPreview" style="width: 150px; height: 150px; overflow: hidden; background: #f1f5f9;">
                                <i class="bi bi-person-bounding-box text-muted fs-1"></i>
                            </div>
                            <label for="foto" class="btn btn-sm btn-primary rounded-pill px-3">Pilih Foto</label>
                            <input type="file" id="foto" name="foto" class="d-none" accept="image/*" onchange="previewImage(this)">
                            <p class="text-muted mt-2 mb-0" style="font-size: 10px;">Format: JPG, PNG (Max 2MB)</p>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control rounded-3" placeholder="Nama sesuai KTM" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">NIM</label>
                                    <input type="text" id="nimInput" name="nim" class="form-control rounded-3" placeholder="Masukkan NIM" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control rounded-3" placeholder="name@student.polinema.ac.id" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">WhatsApp</label>
                                    <input type="tel" name="social[whatsapp]" class="form-control rounded-3" placeholder="08XXXXXXXXXX">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Program Studi</label>
                                    <select name="prodi" class="form-select rounded-3" required>
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

                <div class="admin-widget-card bg-white p-4 rounded-4 shadow-sm mb-4">
                    <h5 class="section-title fw-bold mb-4 border-bottom pb-3 text-primary"><i class="bi bi-award me-2"></i> Keanggotaan</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Angkatan (Tahun)</label>
                            <input type="number" name="angkatan" class="form-control rounded-3" min="2000" max="2099" value="<?= date('Y') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Generasi</label>
                            <select name="generasi" class="form-select rounded-3">
                                <?php for ($i = 1; $i <= 20; $i++): ?>
                                    <option value="<?= $i ?>">Gen <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-select rounded-3" onchange="handleJabatanChange()">
                                <optgroup label="Jabatan Umum">
                                    <option value="Ketua Umum">Ketua Umum</option>
                                    <option value="Sekretaris Umum">Sekretaris Umum</option>
                                    <option value="Sekretaris 1">Sekretaris 1</option>
                                    <option value="Bendahara Umum">Bendahara Umum</option>
                                    
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

                        <div class="col-md-6" id="divisiUtamaContainer">
                            <label class="form-label small fw-bold">Divisi Utama</label>
                            <select name="divisi1" id="divisi1" class="form-select rounded-3" required>
                                <option value="">Pilih Divisi</option>
                                <option value="Software">Software</option>
                                <option value="Mekanik">Mekanik</option>
                                <option value="Elektrik">Elektrik</option>
                                <option value="Humas">Humas</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="divisiTambahanContainer">
                            <label class="form-label small fw-bold">Divisi Tambahan</label>
                            <select name="divisi2" id="divisi2" class="form-select rounded-3">
                                <option value="">Tidak Ada</option>
                                <option value="Humas">Humas</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="admin-widget-card bg-white p-4 rounded-4 shadow-sm mb-4">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="createAccount" name="create_account" onchange="toggleAccountSection(this)" checked>
                        <label class="form-check-label fw-bold text-primary" for="createAccount">Buatkan Akun Login?</label>
                    </div>

                    <div id="accountSection" class="mt-4 border-top pt-4">
                        <div class="alert alert-info border-0 rounded-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Saran:</strong> Gunakan NIM sebagai kredensial awal.
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Username</label>
                                <input type="text" id="usernameField" name="username" class="form-control bg-light rounded-3" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Password Default</label>
                                <input type="text" id="passwordField" name="password" class="form-control bg-light rounded-3" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-end gap-3 mb-5">
                    <a href="/admin/members" class="btn btn-light px-5 rounded-pill border fw-bold order-2 order-md-1">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 rounded-pill shadow fw-bold order-1 order-md-2">Simpan Anggota</button>
                </div>
            </form>

            <footer class="mt-5 text-center py-4 border-top small text-muted">
                © <?= date("Y"); ?> <strong>EEPROM POLINEMA</strong> - Developed by Nisho
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const nimInput = document.getElementById('nimInput');
        const usernameField = document.getElementById('usernameField');
        const passwordField = document.getElementById('passwordField');
        const createAccountCheckbox = document.getElementById('createAccount');

        nimInput.addEventListener('input', function() {
            if (createAccountCheckbox.checked) {
                usernameField.value = this.value.trim();
                passwordField.value = this.value.trim();
            }
        });

        function toggleAccountSection(checkbox) {
            const section = document.getElementById('accountSection');
            section.style.display = checkbox.checked ? 'block' : 'none';
            if (checkbox.checked) {
                usernameField.value = nimInput.value.trim();
                passwordField.value = nimInput.value.trim();
            }
        }

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
            const jabatan = document.getElementById('jabatan').value;
            const uCont = document.getElementById('divisiUtamaContainer');
            const tCont = document.getElementById('divisiTambahanContainer');
            const d1 = document.getElementById('divisi1');

            const jUmum = ['Ketua Umum', 'Sekretaris Umum', 'Sekretaris 1', 'Bendahara Umum'];

            if (jUmum.includes(jabatan)) {
                uCont.style.display = 'none';
                tCont.style.display = 'none';
                d1.removeAttribute('required');
            } else if (jabatan === 'Anggota') {
                uCont.style.display = 'block';
                tCont.style.display = 'block';
                d1.setAttribute('required', 'required');
                d1.style.pointerEvents = 'auto';
                d1.style.backgroundColor = '';
            } else {
                uCont.style.display = 'block';
                tCont.style.display = 'none';
                if (jabatan.includes('Software')) d1.value = 'Software';
                else if (jabatan.includes('Mekanik')) d1.value = 'Mekanik';
                else if (jabatan.includes('Elektrik')) d1.value = 'Elektrik';
                else if (jabatan.includes('Humas')) d1.value = 'Humas';
                d1.style.pointerEvents = 'none';
                d1.style.backgroundColor = '#f1f5f9';
            }
        }

        document.addEventListener('DOMContentLoaded', handleJabatanChange);
    </script>
</body>

</html>