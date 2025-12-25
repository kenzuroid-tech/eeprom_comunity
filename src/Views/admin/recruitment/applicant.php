<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelamar - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">    
    <link rel="stylesheet" href="/public/assets/css/admin/recruitment/applicant.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
                
        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="/src/Views/admin/recruitment/index.php" class="btn btn-outline-secondary btn-sm me-3 rounded-circle">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h4 class="m-0 fw-bold">Daftar Pelamar</h4>
                        <small class="text-muted">Periode: Open Recruitment Anggota Baru 2024</small>
                    </div>
                </div>
                <button class="btn btn-export shadow-sm px-3 fw-bold">
                    <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                </button>
            </nav>

            <div class="row g-3 mb-4">
                <?php
                $stats = [
                    ['Total', '142', 'var(--secondary-blue)'],
                    ['Pending', '80', '#f9a825'],
                    ['Interview', '25', '#1976d2'],
                    ['Accepted', '20', '#2e7d32'],
                    ['Rejected', '17', '#c62828']
                ];
                foreach ($stats as $stat):
                ?>
                <div class="col-md-2 col-6">
                    <div class="stat-card-mini shadow-sm" style="border-bottom-color: <?= $stat[2] ?>;">
                        <p class="small text-muted mb-1 text-uppercase fw-bold"><?= $stat[0] ?></p>
                        <h3 class="m-0 fw-bold"><?= $stat[1] ?></h3>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="widget-card-admin">
                <form class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold">Cari Pelamar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" placeholder="Nama atau NIM...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Filter</button>
                        <button type="reset" class="btn btn-light w-100 fw-bold border">Reset</button>
                    </div>
                </form>
            </div>

            <div class="bulk-action-bar animate__animated animate__fadeIn" id="bulkBar">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-check-circle-fill me-2"></i> <span id="selectedCount">0</span> Pelamar Terpilih</span>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-light text-primary fw-bold px-3">Interview</button>
                        <button class="btn btn-sm btn-light text-success fw-bold px-3">Accept</button>
                        <button class="btn btn-sm btn-danger fw-bold px-3">Reject</button>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin p-0 border-0 shadow-sm table-container">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="40"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                <th>No</th>
                                <th>Nama Pelamar</th>
                                <th>NIM</th>
                                <th>Prodi / Sem</th>
                                <th>Divisi Diminati</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" class="form-check-input row-checkbox"></td>
                                <td>1</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" class="rounded-circle me-2" width="32">
                                        <span class="fw-bold">Budi Santoso</span>
                                    </div>
                                </td>
                                <td>2241720001</td>
                                <td>D4 TI / Sem 3</td>
                                <td><span class="text-primary fw-bold">Software</span></td>
                                <td><span class="badge-status bg-pending">Pending</span></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye-fill"></i></a>
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"></button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item text-primary" href="#">Interview</a></li>
                                            <li><a class="dropdown-item text-success" href="#">Accept</a></li>
                                            <li><a class="dropdown-item text-danger" href="#">Reject</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/recruitment/applicant.js"></script>
</body>
</html>