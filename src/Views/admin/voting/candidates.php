<?php
// Pastikan variabel dari Controller tersedia
$candidates = $candidates ?? [];
$allMembers = $allMembers ?? []; // Daftar anggota untuk dropdown select
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Candidates - EEPROM Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin/voting/candidates.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Kelola Kandidat</h4>
                </div>
                <button class="btn btn-orange rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#candidateModal">
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Kandidat
                </button>
            </nav>

            <div class="widget-card-admin bg-white p-4 rounded shadow-sm">
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold m-0 text-primary-blue"><i class="bi bi-list-ol me-2"></i>Daftar Kandidat Terdaftar</h5>
                        <small class="text-muted">Nomor urut akan menentukan posisi di surat suara anggota.</small>
                    </div>
                    <a href="/admin/voting" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="80" class="text-center">No Urut</th>
                                <th width="70">Foto</th>
                                <th>Kandidat</th>
                                <th>Divisi</th>
                                <th>Visi & Misi</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($candidates)): ?>
                                <?php foreach ($candidates as $c): ?>
                                    <tr>
                                        <td class="text-center fw-bold fs-5"><?= $c['number_order'] ?></td>
                                        <td>
                                            <img src="<?= !empty($c['photo_url']) ? $c['photo_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($c['name']) . '&background=random' ?>"
                                                class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?= htmlspecialchars($c['name']) ?></div>
                                            <small class="text-muted">NIM: <?= htmlspecialchars($c['nim']) ?></small>
                                        </td>
                                        <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($c['divisi']) ?></span></td>
                                        <td>
                                            <small class="text-truncate d-block" style="max-width: 250px;">
                                                <strong>Visi:</strong> <?= htmlspecialchars($c['visi']) ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-light border" onclick="editCandidate(<?= $c['id'] ?>)"><i class="bi bi-pencil text-primary"></i></button>
                                                <a href="/admin/voting/candidates/delete?id=<?= $c['id'] ?>"
                                                    class="btn btn-sm btn-light border"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kandidat ini?')">
                                                    <i class="bi bi-trash text-danger"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada kandidat yang didaftarkan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="candidateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Form Kandidat Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="/admin/voting/candidates/store" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-md-8">
                                <label class="form-label small fw-bold">Pilih Anggota sebagai Kandidat</label>
                                <select name="user_id" class="form-select" required>
                                    <option value="">Pilih Anggota...</option>
                                    <?php foreach ($allMembers as $m): ?>
                                        <option value="<?= $m['user_id'] ?>">
                                            <?= $m['nim'] ?> - <?= htmlspecialchars($m['nama_lengkap']) ?> (<?= $m['divisi'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Nomor Urut</label>
                                <input type="number" name="number_order" class="form-control" placeholder="Contoh: 1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Visi</label>
                            <textarea name="visi" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Misi</label>
                            <textarea name="misi" class="form-control" rows="4" placeholder="Tuliskan misi poin per poin..." required></textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-bold">Foto Kandidat (Opsi Khusus)</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <small class="text-muted">Biarkan kosong untuk menggunakan foto profil member.</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Kandidat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>

</body>

</html>