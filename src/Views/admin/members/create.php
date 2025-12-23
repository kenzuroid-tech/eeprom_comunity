<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/img/eeprom logo.png" type="image/png">
    
    <link rel="stylesheet" href="/public/assets/css/admin/members/create.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="m-0 fw-bold">Tambah Anggota Baru</h4>
                </div>
                
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin+EEPROM&background=1A237E&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
                        <span class="d-none d-sm-inline text-dark fw-bold">Super Admin</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <form id="memberForm" action="/admin/members/create.php" method="POST" enctype="multipart/form-data">
                <div class="widget-card-admin">
                    <h5 class="section-title"><i class="bi bi-person-badge"></i> Data Pribadi</h5>
                    <div class="row g-4">
                        <div class="col-lg-3 text-center border-end">
                            <div class="photo-preview-box mx-auto mb-3" id="photoPreview">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                            <label for="foto" class="btn btn-sm btn-outline-primary">Pilih Foto</label>
                            <input type="file" id="foto" name="foto" class="d-none" accept="image/*">
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
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
                                    <label class="form-label small fw-bold">Phone / WhatsApp</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="08XXXXXXXXXX" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Program Studi</label>
                                    <select name="prodi" class="form-select" required>
                                        <option value="" disabled selected>Pilih Program Studi</option>
                                        <option value="TI">Teknik Informatika (TI)</option>
                                        <option value="SIB">Sistem Informasi Bisnis (SIB)</option>
                                        <option value="PPLS">PJJ Pembuatan Perangkat Lunak & Sistem (PPLS)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-card-admin">
                    <h5 class="section-title"><i class="bi bi-award"></i> Data Keanggotaan</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Angkatan (Tahun)</label>
                            <input type="number" name="angkatan" class="form-control" min="2000" max="2099" value="2024">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Generasi</label>
                            <select name="generasi" class="form-select" id="generasiSelect">
                                </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Divisi</label>
                            <select name="divisi" class="form-select" required>
                                <option value="mekanik">Mekanik</option>
                                <option value="software">Software</option>
                                <option value="elektrik">Elektrik</option>
                                <option value="humas">Humas</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Jabatan</label>
                            <select name="jabatan" class="form-select">
                                <option value="anggota">Anggota</option>
                                <option value="ketua">Ketua Umum</option>
                                <option value="wakil">Wakil Ketua</option>
                                <option value="koordinator">Koordinator Divisi</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold d-block">Status</label>
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
                            <label class="form-label small fw-bold">Tanggal Bergabung</label>
                            <input type="date" name="join_date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="widget-card-admin">
                    <h5 class="section-title"><i class="bi bi-body-text"></i> Bio & Keterampilan</h5>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Bio</label>
                        <textarea name="bio" class="form-control" rows="3" placeholder="Deskripsikan diri singkat..."></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Skills</label>
                        <div class="input-group">
                            <input type="text" id="skillInput" class="form-control" placeholder="Contoh: Arduino (Tekan Enter)">
                            <button type="button" class="btn btn-secondary" id="addSkill">Tambah</button>
                        </div>
                        <div id="skillsContainer" class="mt-3"></div>
                    </div>
                </div>

                <div class="widget-card-admin">
                    <h5 class="section-title"><i class="bi bi-share"></i> Social Media</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                <input type="url" name="instagram" class="form-control" placeholder="Instagram URL">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-linkedin"></i></span>
                                <input type="url" name="linkedin" class="form-control" placeholder="LinkedIn URL">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-github"></i></span>
                                <input type="url" name="github" class="form-control" placeholder="GitHub URL">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-card-admin">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="createAccount" name="create_account">
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
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Konfirmasi Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mb-5">
                    <a href="/admin/members.php" class="btn btn-light px-5">Batal</a>
                    <button type="submit" class="btn btn-orange px-5 shadow">Simpan Anggota</button>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/members/create.js"></script>
</body>
</html>