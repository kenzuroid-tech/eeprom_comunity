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
                                <input type="file" name="foto" id="fotoInput" hidden accept="image/*">
                            </label>
                            <div class="small text-muted">Format: JPG, PNG (Max 2MB)</div>
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
                                        <option value="D4 Teknik Elektronika" <?= ($member['prodi'] == 'D4 Teknik Elektronika') ? 'selected' : '' ?>>D4 Teknik Elektronika</option>
                                        <option value="D4 Teknik Informatika" <?= ($member['prodi'] == 'D4 Teknik Informatika') ? 'selected' : '' ?>>D4 Teknik Informatika</option>
                                        <option value="D4 Teknik Informatika" <?= ($member['prodi'] == 'D4 Teknik Informatika') ? 'selected' : '' ?>>D4 Teknik Informatika</option>
                                        <option value="D4 Sistem Kelistrikan" <?= ($member['prodi'] == 'D4 Sistem Kelistrikan') ? 'selected' : '' ?>>D4 Sistem Kelistrikan</option>
                                        <option value="D4 Jaringan Telekomunikasi Digital" <?= ($member['prodi'] == 'D4 Jaringan Telekomunikasi Digital') ? 'selected' : '' ?>>D4 Jaringan Telekomunikasi Digital</option>
                                        <option value="D3 Teknik Elektronika" <?= ($member['prodi'] == 'D3 Teknik Elektronika') ? 'selected' : '' ?>>D3 Teknik Elektronika</option>
                                        <option value="D3 Teknik Telekomunikasi" <?= ($member['prodi'] == 'D3 Teknik Telekomunikasi') ? 'selected' : '' ?>>D3 Teknik Telekomunikasi</option>
                                        <option value="D3 Teknik Listrik" <?= ($member['prodi'] == 'D3 Teknik Listrik') ? 'selected' : '' ?>>D3 Teknik Listrik</option>
                                        <option value="D3 Teknik Mesin" <?= ($member['prodi'] == 'D3 Teknik Mesin') ? 'selected' : '' ?>>D3 Teknik Mesin</option>
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

                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-select" onchange="handleJabatanChange()">
                                <optgroup label="Jabatan Umum">
                                    <option value="Ketua Umum" <?= ($member['jabatan'] == 'Ketua Umum') ? 'selected' : '' ?>>Ketua Umum</option>
                                    <option value="Wakil Ketua" <?= ($member['jabatan'] == 'Wakil Ketua') ? 'selected' : '' ?>>Wakil Ketua</option>
                                    <option value="Sekretaris" <?= ($member['jabatan'] == 'Sekretaris') ? 'selected' : '' ?>>Sekretaris</option>
                                    <option value="Sekretaris 1" <?= ($member['jabatan'] == 'Sekretaris 1') ? 'selected' : '' ?>>Sekretaris 1</option>
                                    <option value="Bendahara" <?= ($member['jabatan'] == 'Bendahara') ? 'selected' : '' ?>>Bendahara</option>
                                </optgroup>

                                <optgroup label="Divisi Software">
                                    <option value="Kepala Divisi Software" <?= ($member['jabatan'] == 'Kepala Divisi Software') ? 'selected' : '' ?>>Kepala Divisi Software</option>
                                    <option value="Wakil Kepala Divisi Software" <?= ($member['jabatan'] == 'Wakil Kepala Divisi Software') ? 'selected' : '' ?>>Wakil Kepala Divisi Software</option>
                                </optgroup>

                                <optgroup label="Divisi Mekanik">
                                    <option value="Kepala Divisi Mekanik" <?= ($member['jabatan'] == 'Kepala Divisi Mekanik') ? 'selected' : '' ?>>Kepala Divisi Mekanik</option>
                                    <option value="Wakil Kepala Divisi Mekanik RnD 1" <?= ($member['jabatan'] == 'Wakil Kepala Divisi Mekanik RnD 1') ? 'selected' : '' ?>>Wakil Kepala Divisi Mekanik RnD 1</option>
                                    <option value="Wakil Kepala Divisi Mekanik RnD 2" <?= ($member['jabatan'] == 'Wakil Kepala Divisi Mekanik RnD 2') ? 'selected' : '' ?>>Wakil Kepala Divisi Mekanik RnD 2</option>
                                    <option value="Wakil Kepala Divisi Mekanik Manufaktur" <?= ($member['jabatan'] == 'Wakil Kepala Divisi Mekanik Manufaktur') ? 'selected' : '' ?>>Wakil Kepala Divisi Mekanik Manufaktur</option>
                                </optgroup>

                                <optgroup label="Divisi Elektrik">
                                    <option value="Kepala Divisi Elektrik" <?= ($member['jabatan'] == 'Kepala Divisi Elektrik') ? 'selected' : '' ?>>Kepala Divisi Elektrik</option>
                                    <option value="Wakil Kepala Divisi Elektrik Power" <?= ($member['jabatan'] == 'Wakil Kepala Divisi Elektrik Power') ? 'selected' : '' ?>>Wakil Kepala Divisi Elektrik Power</option>
                                    <option value="Wakil Kepala Divisi Elektrik Control" <?= ($member['jabatan'] == 'Wakil Kepala Divisi Elektrik Control') ? 'selected' : '' ?>>Wakil Kepala Divisi Elektrik Control</option>
                                </optgroup>

                                <optgroup label="Divisi Humas">
                                    <option value="Kepala Divisi Humas" <?= ($member['jabatan'] == 'Kepala Divisi Humas') ? 'selected' : '' ?>>Kepala Divisi Humas</option>
                                    <option value="Wakil Kepala Divisi Humas Internal" <?= ($member['jabatan'] == 'Wakil Kepala Divisi Humas Internal') ? 'selected' : '' ?>>Wakil Kepala Divisi Humas Internal</option>
                                    <option value="Wakil Kepala Divisi Humas Eksternal" <?= ($member['jabatan'] == 'Wakil Kepala Divisi Humas Eksternal') ? 'selected' : '' ?>>Wakil Kepala Divisi Humas Eksternal</option>
                                    <option value="Wakil Kepala Divisi Humas Media" <?= ($member['jabatan'] == 'Wakil Kepala Divisi Humas Media') ? 'selected' : '' ?>>Wakil Kepala Divisi Humas Media</option>
                                </optgroup>

                                <optgroup label="Anggota">
                                    <option value="Anggota" <?= ($member['jabatan'] == 'Anggota') ? 'selected' : '' ?>>Anggota</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="col-md-6" id="divisiUtamaContainer">
                            <label class="form-label fw-bold small">Divisi Utama</label>
                            <select name="divisi1" id="divisi1" class="form-select">
                                <option value="">Pilih Divisi</option>
                                <option value="Software" <?= (strpos($member['divisi'] ?? '', 'Software') !== false) ? 'selected' : '' ?>>Software</option>
                                <option value="Mekanik" <?= (strpos($member['divisi'] ?? '', 'Mekanik') !== false) ? 'selected' : '' ?>>Mekanik</option>
                                <option value="Elektrik" <?= (strpos($member['divisi'] ?? '', 'Elektrik') !== false) ? 'selected' : '' ?>>Elektrik</option>
                                <option value="Humas" <?= ($member['divisi'] === 'Humas') ? 'selected' : '' ?>>Humas</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="divisiTambahanContainer">
                            <label class="form-label fw-bold small">Divisi Tambahan</label>
                            <select name="divisi2" id="divisi2" class="form-select">
                                <option value="">Tidak Ada</option>
                                <option value="Humas" <?= (strpos($member['divisi'] ?? '', ', Humas') !== false) ? 'selected' : '' ?>>Humas</option>
                            </select>
                        </div>

                        <!-- <div class="col-md-4">
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
                        </div> -->

                        <div class="col-md-4">
                            <label class="form-label fw-bold small d-block">Status Keanggotaan</label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_keanggotaan" id="stActive" value="Active" <?= ($member['status_keanggotaan'] !== 'Alumni') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="stActive">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_keanggotaan" id="stAlumni" value="Alumni" <?= ($member['status_keanggotaan'] == 'Alumni') ? 'checked' : '' ?>>
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
    <script>
        function handleJabatanChange() {
            const jabatanSelect = document.getElementById('jabatan');
            const divisiUtamaContainer = document.getElementById('divisiUtamaContainer');
            const divisiTambahanContainer = document.getElementById('divisiTambahanContainer');
            const divisi1Select = document.getElementById('divisi1');
            const divisi2Select = document.getElementById('divisi2');

            const selectedJabatan = jabatanSelect.value;

            // List jabatan umum (tidak perlu divisi)
            const jabatanUmum = ['Ketua Umum', 'Wakil Ketua', 'Sekretaris', 'Sekretaris 1', 'Bendahara'];

            // Reset style divisi1
            divisi1Select.removeAttribute('readonly');
            divisi1Select.style.pointerEvents = '';
            divisi1Select.style.backgroundColor = '';

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
                divisi1Select.setAttribute('required', 'required');
            }
        }

        // Jalankan saat halaman load
        document.addEventListener('DOMContentLoaded', function() {
            handleJabatanChange();
        });

        // Tambahkan ini di dalam script yang sudah ada
        document.getElementById('fotoInput').addEventListener('change', function(e) {
            const reader = new FileReader();
            const imageElement = document.querySelector('.col-lg-3 img'); // Mengambil element foto profil

            reader.onload = function(e) {
                imageElement.src = e.target.result;
            }

            if (this.files[0]) {
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>

    <style>
        select[readonly] {
            background-color: #e9ecef !important;
            cursor: not-allowed;
        }
    </style>
</body>

</html>