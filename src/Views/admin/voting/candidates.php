<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Candidates - EEPROM Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="/public/assets/css/admin/voting/candidates.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Kelola Kandidat</h4>
                </div>
                <button class="btn btn-orange rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#candidateModal">
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Kandidat
                </button>
            </nav>

            <div class="election-info-banner shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1">Pemilihan Ketua Umum EEPROM 2025/2026</h5>
                        <p class="mb-0 opacity-75 small"><i class="bi bi-calendar3 me-2"></i>Periode: 15 Des 2025 - 20 Des 2025 | <span class="badge bg-white text-primary">Status: Draft</span></p>
                    </div>
                    <a href="index.php" class="btn btn-sm btn-light text-primary fw-bold"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                </div>
            </div>

            <div class="widget-card-admin">
                <div class="mb-4">
                    <h5 class="fw-bold m-0 text-primary-blue"><i class="bi bi-list-ol me-2"></i>Daftar Kandidat</h5>
                    <small class="text-muted">Klik dan tarik baris untuk mengatur nomor urut.</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="80" class="text-center">No Urut</th>
                                <th width="50"></th>
                                <th width="70">Foto</th>
                                <th>Kandidat</th>
                                <th>Generasi/Divisi</th>
                                <th>Visi Misi Preview</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="candidateSortable">
                            <tr draggable="true" data-id="1">
                                <td class="text-center fw-bold fs-5">1</td>
                                <td><i class="bi bi-grip-vertical drag-handle"></i></td>
                                <td><img src="https://ui-avatars.com/api/?name=Kandidat+1&background=1A237E&color=fff" class="candidate-avatar" alt="Avatar"></td>
                                <td>
                                    <div class="fw-bold">Kandidat 1</div>
                                    <small class="text-muted">NIM: 3210101001</small>
                                </td>
                                <td>Gen 16 / Software</td>
                                <td class="text-truncate" style="max-width: 200px;">Mewujudkan EEPROM sebagai pusat inovasi robotika...</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-light border" onclick="editCandidate(1)"><i class="bi bi-pencil text-primary"></i></button>
                                        <button class="btn btn-sm btn-light border" onclick="deleteCandidate(1)"><i class="bi bi-trash text-danger"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr draggable="true" data-id="2">
                                <td class="text-center fw-bold fs-5">2</td>
                                <td><i class="bi bi-grip-vertical drag-handle"></i></td>
                                <td><img src="https://ui-avatars.com/api/?name=Kandidat+2&background=FF5722&color=fff" class="candidate-avatar" alt="Avatar"></td>
                                <td>
                                    <div class="fw-bold">Kandidat 2</div>
                                    <small class="text-muted">NIM: 3210101005</small>
                                </td>
                                <td>Gen 16 / Elektrik</td>
                                <td class="text-truncate" style="max-width: 200px;">Menciptakan komunitas yang solid dan kompetitif...</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-light border" onclick="editCandidate(2)"><i class="bi bi-pencil text-primary"></i></button>
                                        <button class="btn btn-sm btn-light border" onclick="deleteCandidate(2)"><i class="bi bi-trash text-danger"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="candidateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white" style="background-color: var(--primary-blue) !important;">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-fill-gear me-2"></i>Form Kandidat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="candidateForm">
                    <div class="modal-body p-4">
                        <h6 class="text-primary-blue fw-bold mb-3 border-bottom pb-2">Identitas Kandidat</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Cari Anggota Aktif</label>
                                <select class="form-select" id="memberSelect" required>
                                    <option value="">Pilih Anggota...</option>
                                    <option value="1" data-name="Ahmad Fauzi" data-gen="Gen 17" data-div="Mekanik">3220101001 - Ahmad Fauzi (Mekanik)</option>
                                    <option value="2" data-name="Maya Sari" data-gen="Gen 16" data-div="Humas">3210101015 - Maya Sari (Humas)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama (Auto)</label>
                                <input type="text" id="candidateName" class="form-control bg-light" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Generasi (Auto)</label>
                                <input type="text" id="candidateGen" class="form-control bg-light" readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-bold">Urutan</label>
                                <input type="number" class="form-control" value="1" min="1">
                            </div>
                        </div>

                        <h6 class="text-primary-blue fw-bold mb-3 border-bottom pb-2">Visi, Misi & Proker</h6>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Visi</label>
                            <textarea class="form-control" rows="3" placeholder="Tuliskan visi besar kandidat..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Misi (Tambah satu per satu)</label>
                            <div class="input-group mb-2">
                                <input type="text" id="inputMisi" class="form-control" placeholder="Contoh: Mengadakan pelatihan rutin mingguan">
                                <button class="btn btn-secondary" type="button" id="btnAddMisi"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div id="containerMisi"></div>
                        </div>

                        <div>
                            <label class="form-label small fw-bold">Program Kerja Unggulan</label>
                            <div class="input-group mb-2">
                                <input type="text" id="inputProker" class="form-control" placeholder="Contoh: EEPROM Competition 2025">
                                <button class="btn btn-secondary" type="button" id="btnAddProker"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div id="containerProker"></div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-orange px-4">Simpan Kandidat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/voting/candidates.js"></script>
</body>
</html>