<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    
    <link rel="stylesheet" href="/public/assets/css/member-area/attendance/index.css">
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
                    <h4 class="m-0 fw-bold">My Attendance</h4>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=Nisho&background=1A237E&color=fff" alt="Profile" width="35" class="rounded-circle me-2">
                            <span class="d-none d-sm-inline text-dark fw-bold small">Nisho</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="/member/profile.php"><i class="bi bi-person me-2"></i>Profile Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="row g-4 mb-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card-member">
                        <p class="small text-muted mb-1">Total Pertemuan</p>
                        <h3>24</h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member" style="border-left-color: #28a745;">
                        <p class="small text-muted mb-1">Total Hadir</p>
                        <h3 style="color: #28a745;">20</h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member" style="border-left-color: #f44336;">
                        <p class="small text-muted mb-1">Tidak Hadir</p>
                        <h3 style="color: #f44336;">4</h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card-member" style="border-left-color: #ffc107;">
                        <p class="small text-muted mb-1">Persentase</p>
                        <h3 style="color: #ffc107;">83%</h3>
                    </div>
                </div>
            </div>

            <div class="widget-card-member">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm" style="width: 120px; border-radius: 8px;">
                            <option value="2025">Tahun 2025</option>
                            <option value="2024">Tahun 2024</option>
                        </select>
                        <select class="form-select form-select-sm" style="width: 150px; border-radius: 8px;">
                            <option value="All">Semua Status</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Tidak Hadir">Tidak Hadir</option>
                            <option value="Izin">Izin</option>
                        </select>
                    </div>
                    <button class="btn btn-export"><i class="bi bi-file-earmark-pdf me-2"></i>Export PDF</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Pertemuan</th>
                                <th>Tanggal & Waktu</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="fw-bold">Rapat Koordinasi KRI 2024</td>
                                <td>15 Mar 2025, 18:30</td>
                                <td>Lab Robotika AF</td>
                                <td><span class="status-badge bg-hadir">Hadir</span></td>
                                <td class="text-muted small">-</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="fw-bold">Workshop Arduino Lanjutan</td>
                                <td>12 Mar 2025, 13:00</td>
                                <td>Sekretariat</td>
                                <td><span class="status-badge bg-izin">Izin</span></td>
                                <td class="text-muted small">Ada praktikum susulan</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="fw-bold">Briefing Kontes Robot Tematik</td>
                                <td>05 Mar 2025, 19:00</td>
                                <td>Gedung AO Lt. 2</td>
                                <td><span class="status-badge bg-tidak">Tidak Hadir</span></td>
                                <td class="text-muted small">Tanpa keterangan</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="fw-bold">Evaluasi Bulanan Maret</td>
                                <td>01 Mar 2025, 18:30</td>
                                <td>Lab Robotika AF</td>
                                <td><span class="status-badge bg-hadir">Hadir</span></td>
                                <td class="text-muted small">-</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="fw-bold">Pelatihan Desain PCB</td>
                                <td>20 Feb 2025, 15:00</td>
                                <td>Sekretariat</td>
                                <td><span class="status-badge bg-hadir">Hadir</span></td>
                                <td class="text-muted small">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <nav class="mt-4">
                    <ul class="pagination pagination-sm justify-content-end mb-0 shadow-none">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#" style="background-color: var(--primary-blue); border-color: var(--primary-blue);">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

            <footer class="mt-5 text-center py-3 border-top small text-muted">
                © 2024 EEPROM POLINEMA - Member Attendance System
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/member-area/attendance/index.js"></script>
</body>
</html>