<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents & Archives - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/member-area/documents/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../../layouts/sidebar-ma.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">

            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="m-0 fw-bold">Documents & Archives</h4>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=Member+EEPROM&background=1A237E&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
                            <span class="d-none d-sm-inline text-dark fw-bold small">Nisho</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="widget-card-docs">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control bg-light border-0" placeholder="Search documents by title...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select bg-light border-0">
                            <option value="">All Categories</option>
                            <option value="SOP">SOP</option>
                            <option value="Guidelines">Guidelines</option>
                            <option value="Forms">Forms</option>
                            <option value="Reports">Reports</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100 border-0" style="background-color: var(--secondary-blue);">Filter</button>
                    </div>
                </div>
            </div>

            <div class="widget-card-docs">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Category</th>
                                <th>Size</th>
                                <th>Upload Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark-pdf-fill file-icon icon-pdf"></i>
                                        <span class="fw-bold text-dark">SOP Recruitment 2024.pdf</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge bg-sop">SOP</span></td>
                                <td class="small">1.2 MB</td>
                                <td class="small">15 Okt 2024</td>
                                <td class="text-center">
                                    <button class="btn-download-doc"><i class="bi bi-download me-2"></i>Download</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark-word-fill file-icon icon-doc"></i>
                                        <span class="fw-bold text-dark">Form Pengajuan Dana Kegiatan.docx</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge bg-forms">Forms</span></td>
                                <td class="small">856 KB</td>
                                <td class="small">20 Okt 2024</td>
                                <td class="text-center">
                                    <button class="btn-download-doc"><i class="bi bi-download me-2"></i>Download</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark-excel-fill file-icon icon-xls"></i>
                                        <span class="fw-bold text-dark">Laporan Akhir KRI 2023.xlsx</span>
                                    </div>
                                </td>
                                <td><span class="cat-badge bg-reports">Reports</span></td>
                                <td class="small">2.5 MB</td>
                                <td class="small">05 Nov 2024</td>
                                <td class="text-center">
                                    <button class="btn-download-doc"><i class="bi bi-download me-2"></i>Download</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link border-0" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link border-0" href="#" style="background-color: var(--primary-blue);">1</a></li>
                        <li class="page-item"><a class="page-link border-0 text-dark" href="#">2</a></li>
                        <li class="page-item"><a class="page-link border-0 text-dark" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

            <footer class="mt-5 text-center py-3 border-top small text-muted">
                © <?php echo date("Y"); ?> EEPROM POLINEMA
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/member-area/documents/index.js"></script>
</body>

</html>