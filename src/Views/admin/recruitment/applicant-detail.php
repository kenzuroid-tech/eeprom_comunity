<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelamar - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">    
    <link rel="stylesheet" href="/public/assets/css/admin/recruitment/applicant-detail.css">
</head>
<body>

    <div class="dashboard-wrapper">
        <nav class="sidebar" id="sidebarMenu">
            <div class="sidebar-header">
                <img src="/img/eeprom logo.png" alt="Logo" width="40" class="mb-2">
                <h3>EEPROM Admin</h3>
            </div>
            <div class="sidebar-nav">
                <a href="/admin/dashboard.php" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                <a href="/admin/recruitment.php" class="nav-link active"><i class="bi bi-people-fill me-2"></i>Recruitment</a>
                <a href="#" class="nav-link"><i class="bi bi-megaphone-fill me-2"></i>Announcements</a>
                <a href="/logout.php" class="nav-link text-danger mt-auto"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
            </div>
        </nav>

        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="/admin/recruitment/applicants.php" class="btn btn-light rounded-circle me-3 border"><i class="bi bi-arrow-left"></i></a>
                    <h4 class="m-0 fw-bold">Detail Pelamar</h4>
                </div>
                <div class="d-flex align-items-center">
                    <span class="status-badge status-reviewing me-3">
                        <i class="bi bi-clock-history me-1"></i> STATUS: REVIEWING
                    </span>
                </div>
            </nav>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="widget-card-admin">
                        <h5 class="section-title"><i class="bi bi-person-badge me-2"></i>Data Pribadi</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="label-detail">Nama Lengkap</p>
                                <p class="value-detail">Reza Aditya Pratama</p>
                                <p class="label-detail">NIM</p>
                                <p class="value-detail">2241720000</p>
                                <p class="label-detail">Email</p>
                                <p class="value-detail">reza.aditya@student.polinema.ac.id</p>
                            </div>
                            <div class="col-md-6">
                                <p class="label-detail">WhatsApp</p>
                                <p class="value-detail">
                                    <a href="https://wa.me/628123456789" target="_blank" class="text-decoration-none text-success fw-bold">
                                        <i class="bi bi-whatsapp me-1"></i> +62 812-3456-789
                                    </a>
                                </p>
                                <p class="label-detail">Prodi & Semester</p>
                                <p class="value-detail">D4 Teknik Informatika - Semester 3</p>
                                <p class="label-detail">Angkatan</p>
                                <p class="value-detail">2022</p>
                            </div>
                        </div>
                    </div>

                    <div class="widget-card-admin">
                        <h5 class="section-title"><i class="bi bi-rocket-takeoff me-2"></i>Divisi & Motivasi</h5>
                        <div class="mb-4">
                            <p class="label-detail">Divisi yang Diminati</p>
                            <span class="badge bg-primary px-3 py-2 rounded-pill me-2">Software</span>
                            <span class="badge bg-secondary px-3 py-2 rounded-pill">Elektrik</span>
                        </div>
                        <div class="mb-4">
                            <p class="label-detail">Alasan Bergabung</p>
                            <p class="text-dark small lh-lg">Saya sangat tertarik dengan robotika sejak sekolah menengah. Saya ingin mengasah kemampuan problem solving saya dalam pemrograman embedded system...</p>
                        </div>
                        <div>
                            <p class="label-detail">Skills</p>
                            <p class="text-dark small lh-lg">C++, Arduino IDE, Basic Python, Circuit Design, Team Leadership.</p>
                        </div>
                    </div>

                    <div class="widget-card-admin">
                        <h5 class="section-title"><i class="bi bi-folder2-open me-2"></i>Dokumen & Portfolio</h5>
                        <div class="row g-4 mb-4 text-center">
                            <div class="col-md-4">
                                <div class="p-3 border rounded">
                                    <i class="bi bi-instagram fs-3 text-danger mb-2"></i>
                                    <p class="small fw-bold mb-0">Instagram</p>
                                    <a href="#" class="btn btn-link btn-sm p-0">Visit Profile</a>
                                </div>
                            </div>
                            </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="label-detail mb-0">CV / Resume (PDF)</p>
                                <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-download me-1"></i>Download</a>
                            </div>
                            <div class="pdf-preview">
                                <span class="text-muted"><i class="bi bi-file-pdf me-2"></i>Preview CV: CV_RezaAditya.pdf</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="widget-card-admin">
                        <h5 class="fw-bold mb-3 small text-uppercase">Update Status</h5>
                        <select class="form-select mb-3">
                            <option value="Pending">Pending</option>
                            <option value="Reviewing" selected>Reviewing</option>
                            <option value="Interview">Interview</option>
                            <option value="Accepted">Accepted</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                        <button class="btn btn-primary w-100 fw-bold">Save Status</button>
                    </div>

                    <div class="widget-card-admin">
                        <h5 class="fw-bold mb-3 small text-uppercase">Catatan Admin</h5>
                        <textarea class="form-control mb-3" rows="4" placeholder="Tambahkan catatan..."></textarea>
                        <button class="btn btn-outline-primary w-100 fw-bold">Save Note</button>
                    </div>

                    <div class="widget-card-admin">
                        <h5 class="fw-bold mb-3 small text-uppercase text-danger">Quick Actions</h5>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success fw-bold"><i class="bi bi-check-circle me-2"></i>Accept</button>
                            <button class="btn btn-outline-danger fw-bold"><i class="bi bi-x-circle me-2"></i>Reject</button>
                        </div>
                    </div>

                    <div class="widget-card-admin">
                        <h5 class="fw-bold mb-4 small text-uppercase">Timeline Activity</h5>
                        <div class="timeline-container">
                            <div class="timeline-item">
                                <p class="small mb-0 fw-bold">Note added by Admin</p>
                                <p class="small text-muted" style="font-size: 11px;">15 Oct 2024, 14:20</p>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/recruitment/applicant-detail.js"></script>
</body>
</html>