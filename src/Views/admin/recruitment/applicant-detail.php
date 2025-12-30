<?php
/**
 * File: src/Views/admin/recruitment/detail.php
 */
$adminData = $adminData ?? [];
$applicant = $applicant ?? [];

// Jika data kosong, cegah error
if (empty($applicant)) {
    die("Data pelamar tidak ditemukan.");
}

// Map warna status untuk badge di top navbar
$statusColor = match($applicant['status']) {
    'Accepted' => 'bg-success',
    'Rejected' => 'bg-danger',
    'Interview' => 'bg-info',
    'Reviewing' => 'bg-primary',
    default => 'bg-warning text-dark'
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelamar - <?= htmlspecialchars($applicant['nama_lengkap']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">    
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin/recruitment/applicant-detail.css">
</head>
<body>

    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <div class="d-flex align-items-center">
                    <a href="/admin/recruitment/applicants?id=<?= $applicant['period_id'] ?>" class="btn btn-light rounded-circle me-3 border">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h4 class="m-0 fw-bold">Detail Pelamar</h4>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge <?= $statusColor ?> px-3 py-2 rounded-pill">
                        <i class="bi bi-clock-history me-1"></i> STATUS: <?= strtoupper($applicant['status']) ?>
                    </span>
                </div>
            </nav>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                        <h5 class="section-title fw-bold mb-4 border-bottom pb-2 text-primary">
                            <i class="bi bi-person-badge me-2"></i>Data Pribadi
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="label-detail text-muted small mb-1">Nama Lengkap</p>
                                <p class="value-detail fw-bold mb-3"><?= htmlspecialchars($applicant['nama_lengkap']) ?></p>
                                
                                <p class="label-detail text-muted small mb-1">NIM</p>
                                <p class="value-detail fw-bold mb-3"><?= htmlspecialchars($applicant['nim']) ?></p>
                                
                                <p class="label-detail text-muted small mb-1">Email</p>
                                <p class="value-detail fw-bold mb-3"><?= htmlspecialchars($applicant['email']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="label-detail text-muted small mb-1">WhatsApp</p>
                                <p class="value-detail mb-3">
                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $applicant['whatsapp']) ?>" target="_blank" class="text-decoration-none text-success fw-bold">
                                        <i class="bi bi-whatsapp me-1"></i> <?= htmlspecialchars($applicant['whatsapp']) ?>
                                    </a>
                                </p>
                                
                                <p class="label-detail text-muted small mb-1">Prodi & Semester</p>
                                <p class="value-detail fw-bold mb-3"><?= htmlspecialchars($applicant['prodi']) ?> - Semester <?= $applicant['semester'] ?? '?' ?></p>
                                
                                <p class="label-detail text-muted small mb-1">Angkatan</p>
                                <p class="value-detail fw-bold mb-3"><?= htmlspecialchars($applicant['angkatan'] ?? '-') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                        <h5 class="section-title fw-bold mb-4 border-bottom pb-2 text-primary">
                            <i class="bi bi-rocket-takeoff me-2"></i>Divisi & Motivasi
                        </h5>
                        <div class="mb-4">
                            <p class="label-detail text-muted small mb-2">Divisi yang Diminati</p>
                            <span class="badge bg-primary px-3 py-2 rounded-pill me-2"><?= htmlspecialchars($applicant['divisi_pilihan_1']) ?></span>
                            <?php if(!empty($applicant['divisi_pilihan_2'])): ?>
                                <span class="badge bg-secondary px-3 py-2 rounded-pill"><?= htmlspecialchars($applicant['divisi_pilihan_2']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-4">
                            <p class="label-detail text-muted small mb-1">Alasan Bergabung</p>
                            <p class="text-dark small lh-lg"><?= nl2br(htmlspecialchars($applicant['alasan_bergabung'] ?? 'Tidak ada alasan yang diisi.')) ?></p>
                        </div>
                        <div>
                            <p class="label-detail text-muted small mb-1">Skills</p>
                            <p class="text-dark small lh-lg"><?= htmlspecialchars($applicant['skills'] ?? '-') ?></p>
                        </div>
                    </div>

                    <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                        <h5 class="section-title fw-bold mb-4 border-bottom pb-2 text-primary">
                            <i class="bi bi-folder2-open me-2"></i>Dokumen & Portfolio
                        </h5>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="label-detail mb-0 text-muted small">CV / Resume (PDF)</p>
                                <?php if(!empty($applicant['berkas_url'])): ?>
                                    <a href="<?= $applicant['berkas_url'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Lihat Berkas
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="p-3 border rounded bg-light">
                                <span class="text-muted"><i class="bi bi-file-pdf me-2 text-danger"></i>
                                    <?= !empty($applicant['berkas_url']) ? basename($applicant['berkas_url']) : 'Berkas tidak tersedia' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <form action="/admin/recruitment/status/update" method="POST">
                        <input type="hidden" name="applicant_id" value="<?= $applicant['id'] ?>">
                        <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                            <h5 class="fw-bold mb-3 small text-uppercase">Update Status</h5>
                            <select name="status" class="form-select mb-3">
                                <?php 
                                $statuses = ['Pending', 'Reviewing', 'Interview', 'Accepted', 'Rejected'];
                                foreach($statuses as $st): ?>
                                    <option value="<?= $st ?>" <?= ($applicant['status'] == $st) ? 'selected' : '' ?>><?= $st ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">Save Status</button>
                        </div>
                    </form>

                    <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                        <h5 class="fw-bold mb-3 small text-uppercase">Catatan Admin</h5>
                        <textarea class="form-control mb-3" rows="4" placeholder="Tambahkan catatan..."><?= htmlspecialchars($applicant['admin_note'] ?? '') ?></textarea>
                        <button class="btn btn-outline-primary w-100 fw-bold">Save Note</button>
                    </div>

                    <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4 text-center">
                        <h5 class="fw-bold mb-3 small text-uppercase text-danger">Quick Actions</h5>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success fw-bold"><i class="bi bi-check-circle me-2"></i>Accept Pelamar</button>
                            <button class="btn btn-outline-danger fw-bold"><i class="bi bi-x-circle me-2"></i>Reject Pelamar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>