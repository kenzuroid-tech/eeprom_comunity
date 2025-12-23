<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/img/eeprom logo.png" type="image/png">

    <link rel="stylesheet" href="/public/assets/css/admin/recruitment/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div id="mainContentWrapper" class="main-content-area">
            <?php include '../includes/header.php'; ?>

            <div class="row g-4 mb-4">
                <div class="col-lg-12">
                    <div class="widget-card-admin pb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Active Recruitment Dashboard</h5>
                            <span class="badge bg-success">Periode Ganjil 2024</span>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="countdown-box h-100 d-flex flex-column justify-content-center">
                                    <p class="small mb-1 opacity-75">Sisa Waktu Pendaftaran</p>
                                    <h2 class="fw-black mb-0">12 : 04 : 55</h2>
                                    <p class="small mt-1 opacity-75">Hari : Jam : Menit</p>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="row g-2 h-100">
                                    <div class="col-6">
                                        <div class="stat-mini-box h-100 d-flex flex-column justify-content-center">
                                            <p>Total Aplikasi</p>
                                            <h3 class="fw-bold">142</h3>
                                        </div>
                                    </div>
                                    <div class="col-6 text-start">
                                        <div class="p-2 border rounded-3 bg-white h-100">
                                            <div class="d-flex justify-content-between small mb-1">
                                                <span><i class="bi bi-clock-history text-warning me-1"></i>Pending</span>
                                                <span class="fw-bold">80</span>
                                            </div>
                                            <div class="d-flex justify-content-between small mb-1">
                                                <span><i class="bi bi-check-circle-fill text-success me-1"></i>Accepted</span>
                                                <span class="fw-bold">42</span>
                                            </div>
                                            <div class="d-flex justify-content-between small">
                                                <span><i class="bi bi-x-circle-fill text-danger me-1"></i>Rejected</span>
                                                <span class="fw-bold">20</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="chart-container" style="height: 100px;">
                                            <span class="text-muted small">[ Pie Chart: Applicant Breakdown ]</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h6 class="fw-bold small mb-3">Recent Applicants</h6>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item bg-transparent px-0 py-2 d-flex align-items-center border-0 border-bottom">
                                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso" class="rounded-circle me-2" width="30">
                                        <div class="flex-grow-1"><p class="small mb-0 fw-bold">Budi Santoso</p></div>
                                        <span class="text-muted" style="font-size: 10px;">2m ago</span>
                                    </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-4">Semua Periode Recruitment</h5>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="recruitment-card p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="status-badge badge-active">Active</span>
                            </div>
                        <h5 class="fw-bold mb-1">Open Recruitment 2024</h5>
                        <p class="text-muted small mb-3"><i class="bi bi-calendar3 me-2"></i>01 Okt - 31 Okt 2024</p>
                        <div class="row g-2 mb-4">
                            <div class="col-4"><div class="stat-mini-box"><h6>142</h6><p>Total</p></div></div>
                            <div class="col-4"><div class="stat-mini-box"><h6>80</h6><p>Pending</p></div></div>
                            <div class="col-4"><div class="stat-mini-box"><h6>42</h6><p>Accepted</p></div></div>
                        </div>
                        <a href="#" class="btn btn-outline-primary w-100 btn-sm fw-bold">View Applicants</a>
                    </div>
                </div>
                </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/recruitment/index.js"></script>
</body>
</html>