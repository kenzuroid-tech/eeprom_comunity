<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divisions Management - EEPROM POLINEMA</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/divisions/index.css">
    
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">
            <?php include '../includes/header.php'; ?>

            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <h3 class="fw-bold m-0">Divisions Management</h3>
                    <p class="text-muted">Kelola divisi dan strukturnya</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="btn btn-gold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddDivision">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Divisi
                    </button>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="stat-card-admin">
                        <p class="small text-muted mb-1 text-uppercase fw-bold">📁 Total Divisi</p>
                        <h3 class="fw-black m-0">5</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin" style="border-left-color: #28a745;">
                        <p class="small text-muted mb-1 text-uppercase fw-bold">👥 Total Anggota</p>
                        <h3 class="fw-black m-0">127</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin" style="border-left-color: #ffc107;">
                        <p class="small text-muted mb-1 text-uppercase fw-bold">🎯 Divisi Terbesar</p>
                        <h3 class="fw-black m-0">Programming</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card-admin" style="border-left-color: #f44336;">
                        <p class="small text-muted mb-1 text-uppercase fw-bold">📈 Avg Members</p>
                        <h3 class="fw-black m-0">25.4</h3>
                    </div>
                </div>
            </div>

            <div class="widget-card-admin p-0 overflow-hidden shadow-sm">
                <div class="p-3 bg-light border-bottom">
                    <i class="bi bi-list me-2"></i><small>Drag to reorder divisions</small>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="50"></th>
                                <th width="80">Urutan</th>
                                <th width="80">Icon</th>
                                <th>Nama Divisi</th>
                                <th>Deskripsi</th>
                                <th>Anggota</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="bi bi-list drag-handle"></i></td>
                                <td>1</td>
                                <td class="fs-4">💻</td>
                                <td class="fw-bold">Programming</td>
                                <td class="text-truncate" style="max-width: 200px;">Fokus pada pengembangan software...</td>
                                <td>35</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalViewDivision"><i class="bi bi-eye"></i></button>
                                    <button class="btn btn-sm btn-light text-warning mx-1"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal" data-bs-target="#modalDelete"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/divisions/index.js"></script>
    <script>
        document.querySelectorAll('.dropdown-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const dropdown = btn.nextElementSibling;
                dropdown.classList.toggle('show');
                btn.querySelector('.bi-chevron-down').classList.toggle('rotate');
            });
        });

        document.getElementById('mobile-toggle').addEventListener('click', () => {
            document.getElementById('sidebarMenu').classList.toggle('show');
        });
    </script>
</body>

</html>