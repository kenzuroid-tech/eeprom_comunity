<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Management - EEPROM POLINEMA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">

    <link rel="stylesheet" href="/public/assets/css/admin/members/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">
            <?php include '../includes/header.php'; ?>
            </nav>

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="stat-card-admin" style="border-left-color: #28a745;">
                        <i class="bi bi-person-check fs-2 me-3 text-success"></i>
                        <div><h3 class="m-0">180</h3><p class="small m-0">Anggota Aktif</p></div>
                    </div>
                </div>
                </div>

            <div class="widget-card-admin">
                <ul class="nav nav-tabs nav-tabs-custom mb-4" id="memberTabs">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#all">All Members</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#active">Active</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#alumni">Alumni</a></li>
                </ul>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari nama atau NIM...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select">
                            <option selected>Semua Divisi</option>
                            <option>Software</option>
                            <option>Mekanik</option>
                            <option>Elektrik</option>
                        </select>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-outline-success me-2"><i class="bi bi-file-earmark-excel"></i> Excel</button>
                        <button class="btn btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
                    </div>
                </div>

                <div class="d-flex mb-3 gap-2">
                    <button class="btn btn-sm btn-outline-danger" id="bulkDelete" disabled><i class="bi bi-trash"></i> Delete Selected</button>
                    <button class="btn btn-sm btn-outline-primary" id="bulkAlumni" disabled><i class="bi bi-mortarboard"></i> Mark as Alumni</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" class="form-check-input" id="checkAll"></th>
                                <th>Profil</th>
                                <th>NIM</th>
                                <th>Gen</th>
                                <th>Divisi</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" class="form-check-input item-check"></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Zaidan+Amir" class="avatar-img me-3">
                                        <span class="fw-bold">Zaidan Amir</span>
                                    </div>
                                </td>
                                <td>2241720001</td>
                                <td>17</td>
                                <td><span class="badge bg-primary-subtle text-primary">Software</span></td>
                                <td><span class="badge bg-success-subtle text-success">Active</span></td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-light border text-primary"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></button>
                                    </div>
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
    <script src="/public/assets/js/admin/members/index.js"></script>
</body>
</html>