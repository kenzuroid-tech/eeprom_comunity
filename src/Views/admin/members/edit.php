<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/img/eeprom logo.png" type="image/png">
    
    <link rel="stylesheet" href="/public/assets/css/admin/members/edit.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Edit Data Anggota</h4>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin+EEPROM&background=1A237E&color=fff" width="35" class="rounded-circle me-2">
                        <span class="d-none d-sm-inline text-dark fw-bold">Super Admin</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm rounded-pill"><i class="bi bi-globe me-1"></i> View Public Profile</button>
                    <button class="btn btn-warning btn-sm rounded-pill text-white fw-bold"><i class="bi bi-key me-1"></i> Reset Password</button>
                </div>
                <div class="d-flex gap-2">
                    <button id="toggleStatusBtn" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="bi bi-mortarboard me-1"></i> Make Alumni
                    </button>
                </div>
            </div>

            <form id="editMemberForm">
                <div class="widget-card-admin">
                    <div class="section-title"><i class="bi bi-person-vcard"></i> Informasi Pribadi</div>
                    <div class="row g-4">
                        <div class="col-lg-3 text-center border-end">
                            <div class="photo-preview-wrapper" id="avatarPreview">
                                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=3F51B5&color=fff" alt="Avatar">
                            </div>
                            <label class="btn btn-sm btn-outline-primary mb-2">
                                <i class="bi bi-camera me-1"></i> Ganti Foto
                                <input type="file" id="photoUpload" hidden accept="image/*">
                            </label>
                            <p class="text-muted small">Max 2MB (JPG/PNG)</p>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="full_name" value="Budi Santoso" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">NIM</label>
                                    <input type="text" class="form-control" value="2141720001" readonly id="nimInput">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Email</label>
                                    <input type="email" class="form-control" name="email" value="budi.santo@student.polinema.ac.id" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">WhatsApp</label>
                                    <input type="tel" class="form-control" name="phone" value="081234567890" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Program Studi</label>
                                    <select class="form-select" name="prodi" required>
                                        <option value="TI" selected>Teknik Informatika (TI)</option>
                                        <option value="SIB">Sistem Informasi Bisnis (SIB)</option>
                                        <option value="PPLS">PJJ Pembuatan Perangkat Lunak & Sistem (PPLS)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-title mt-5"><i class="bi bi-diagram-3"></i> Detail Organisasi</div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Angkatan</label>
                            <input type="number" class="form-control" value="2021">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Generasi</label>
                            <select class="form-select">
                                <option>Gen 15</option>
                                <option>Gen 16</option>
                                <option>Gen 17</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Divisi</label>
                            <select class="form-select">
                                <option selected>Software</option>
                                <option>Mekanik</option>
                                <option>Elektrik</option>
                                <option>Humas</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Jabatan</label>
                            <select class="form-select">
                                <option selected>Anggota</option>
                                <option>Ketua Umum</option>
                                <option>Wakil Ketua</option>
                                <option>Koordinator Divisi</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small d-block">Status Keanggotaan</label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="stActive" value="active" checked>
                                    <label class="form-check-label" for="stActive">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="stAlumni" value="alumni">
                                    <label class="form-check-label" for="stAlumni">Alumni</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Tanggal Bergabung</label>
                            <input type="date" class="form-control" value="2021-09-12">
                        </div>
                    </div>

                    <div class="section-title mt-5"><i class="bi bi-journal-text"></i> Bio & Keterampilan</div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Bio Singkat</label>
                        <textarea class="form-control" rows="3">Mahasiswa tingkat akhir yang memiliki ketertarikan tinggi pada pengembangan perangkat lunak sistem robotika.</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Keahlian (Press Enter)</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="skillsInput" placeholder="Contoh: Python, Arduino, PCB Design">
                            <button class="btn btn-outline-secondary" type="button" id="addSkillBtn">Tambah</button>
                        </div>
                        <div id="skillsContainer">
                            </div>
                    </div>

                    <div class="section-title mt-5"><i class="bi bi-share"></i> Social Media</div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">Instagram URL</label>
                            <input type="url" class="form-control" value="https://instagram.com/budisanto">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">LinkedIn URL</label>
                            <input type="url" class="form-control" value="https://linkedin.com/in/budisantoso">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small">GitHub URL</label>
                            <input type="url" class="form-control" value="https://github.com/budidev">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-5">
                    <button type="button" class="btn btn-outline-danger px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i> Delete Member
                    </button>
                    <div class="d-flex gap-2">
                        <a href="/admin/members.php" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-orange px-5 shadow">Update Data</button>
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
                <div class="modal-body p-4">
                    <p>Apakah Anda yakin ingin menghapus data <strong>Budi Santoso</strong> secara permanen?</p>
                    <p class="text-danger small mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Aksi ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger px-4">Ya, Hapus Permanen</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/members/edit.js"></script>
</body>
</html>