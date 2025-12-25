<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/img/eeprom logo.png" type="image/png">

    <style>
        :root {
            --primary-blue: #1A237E;
            --secondary-blue: #3F51B5;
            --accent-orange: #FF5722;
            --light-gray: #F8F9FA;
            --medium-gray: #E8EAF6;
            --dark-text: #212529;
            --soft-text: #495057;
            --shadow-light: rgba(0, 0, 0, 0.08);
            --sidebar-width: 280px;
        }

        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--medium-gray);
            color: var(--soft-text);
            min-height: 100vh;
        }

        /* Layout */
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content-area {
            flex-grow: 1;
            padding: 30px;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
        }

        /* Sidebar Styling (Matched with dashboard.html) */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-blue);
            color: white;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 1030;
            transition: transform 0.3s ease;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar-header {
            padding: 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h3 {
            color: var(--accent-orange);
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex-grow: 1;
            overflow-y: auto;
            padding: 15px 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 25px;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border-left: 5px solid transparent;
            text-decoration: none;
        }

        .sidebar-nav .nav-link i {
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .sidebar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left-color: var(--accent-orange);
            color: white;
            font-weight: 600;
        }

        /* Dropdown Style */
        .nav-dropdown-items {
            background: rgba(0, 0, 0, 0.1);
            list-style: none;
            padding: 0;
            display: none;
        }

        .nav-dropdown-items.show {
            display: block;
        }

        .nav-dropdown-items .nav-link {
            padding-left: 55px;
            font-size: 0.85rem;
        }

        .sidebar-footer {
            padding: 15px;
            text-align: center;
            font-size: 0.75rem;
            background: rgba(0, 0, 0, 0.2);
            color: rgba(255, 255, 255, 0.6);
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 15px 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Widget Card */
        .widget-card-admin {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px var(--shadow-light);
            margin-bottom: 30px;
        }

        /* Table Styling */
        .table thead th {
            background-color: var(--light-gray);
            color: var(--primary-blue);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            border: none;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            font-size: 0.85rem;
            border-color: var(--medium-gray);
        }

        .doc-icon {
            font-size: 1.5rem;
        }

        .icon-pdf {
            color: #f44336;
        }

        .icon-doc {
            color: #2196f3;
        }

        .icon-xls {
            color: #4caf50;
        }

        .btn-upload {
            background-color: var(--accent-orange);
            color: white;
            font-weight: 600;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-upload:hover {
            background-color: #e64a19;
            color: white;
            transform: translateY(-2px);
        }

        /* Modal Customization */
        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid var(--medium-gray);
            padding: 20px 25px;
        }

        .modal-body {
            padding: 25px;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-blue);
            font-size: 0.9rem;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content-area {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="m-0 fw-bold">Management Dokumen & Arsip</h4>
                </div>
                <button class="btn btn-upload" data-bs-toggle="modal" data-bs-target="#modalUpload">
                    <i class="bi bi-cloud-arrow-up me-2"></i>Upload Document
                </button>
            </nav>

            <div class="widget-card-admin">
                <form class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Cari Dokumen</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control bg-light border-0" placeholder="Ketik judul file...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Filter Kategori</label>
                        <select class="form-select bg-light border-0">
                            <option selected>Semua Kategori</option>
                            <option>Laporan Pertanggungjawaban</option>
                            <option>Proposal Kegiatan</option>
                            <option>Materi Workshop</option>
                            <option>Surat Menyurat</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100 fw-bold" style="background-color: var(--primary-blue);">Terapkan Filter</button>
                    </div>
                </form>
            </div>

            <div class="widget-card-admin p-0 border-0 overflow-hidden shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Icon</th>
                                <th>Judul Dokumen</th>
                                <th>Kategori</th>
                                <th>File Size</th>
                                <th>Upload Date</th>
                                <th class="text-center">Downloads</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 text-center"><i class="bi bi-file-earmark-pdf-fill doc-icon icon-pdf"></i></td>
                                <td>
                                    <div class="fw-bold text-dark">LPJ Kegiatan KRI 2024.pdf</div>
                                    <small class="text-muted">Arsip Akhir Tahun</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">LPJ</span></td>
                                <td>2.4 MB</td>
                                <td>15 Des 2025</td>
                                <td class="text-center">45</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-light text-primary" title="View"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-sm btn-light text-warning" title="Edit"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-light text-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 text-center"><i class="bi bi-file-earmark-word-fill doc-icon icon-doc"></i></td>
                                <td>
                                    <div class="fw-bold text-dark">Proposal Workshop Arduino.docx</div>
                                    <small class="text-muted">Draft Pengajuan</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">Proposal</span></td>
                                <td>850 KB</td>
                                <td>10 Des 2025</td>
                                <td class="text-center">12</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-light text-primary" title="View"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-sm btn-light text-warning" title="Edit"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-light text-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top d-flex justify-content-between align-items-center bg-white">
                    <span class="small text-muted">Menampilkan 1-10 dari 25 dokumen</span>
                    <nav>
                        <ul class="pagination pagination-sm m-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
                            <li class="page-item active"><a class="page-link" href="#" style="background-color: var(--primary-blue); border-color: var(--primary-blue);">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpload" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-primary"><i class="bi bi-file-earmark-arrow-up me-2"></i>Upload New Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">File Dokumen</label>
                            <input type="file" class="form-control border-0 bg-light p-3" required>
                            <small class="text-muted mt-1 d-block">Maksimal 10MB (PDF, DOC, XLS, ZIP)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul Dokumen</label>
                            <input type="text" class="form-control bg-light border-0" placeholder="Contoh: Proposal Riset 2024" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select bg-light border-0">
                                <option>Laporan Pertanggungjawaban</option>
                                <option>Proposal Kegiatan</option>
                                <option>Materi Workshop</option>
                                <option>Surat Menyurat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea class="form-control bg-light border-0" rows="3" placeholder="Jelaskan isi dokumen ini..."></textarea>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary fw-bold py-2" style="background-color: var(--primary-blue);">
                                <i class="bi bi-save me-2"></i>Save & Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown Menu Toggle
            const dropdownBtns = document.querySelectorAll('.dropdown-btn');

            dropdownBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const dropdownMenu = this.nextElementSibling;
                    const isOpen = dropdownMenu.classList.contains('show');

                    // Toggle class show
                    dropdownMenu.classList.toggle('show');

                    // Rotate Chevron Icon
                    const icon = this.querySelector('.bi-chevron-down');
                    if (icon) {
                        icon.style.transition = 'transform 0.3s ease';
                        icon.style.transform = !isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
                    }
                });
            });

            // Mobile Sidebar Toggle
            const mobileBtn = document.getElementById('mobile-toggle');
            const sidebar = document.getElementById('sidebarMenu');

            if (mobileBtn && sidebar) {
                mobileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('show');
                });

                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', (e) => {
                    if (window.innerWidth <= 992 &&
                        !sidebar.contains(e.target) &&
                        !mobileBtn.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>

</html>