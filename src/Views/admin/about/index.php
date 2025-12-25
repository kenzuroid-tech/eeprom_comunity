<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Management - EEPROM POLINEMA</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/public/assets/css/admin/about/index.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">

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
                    <h4 class="m-0 fw-bold">About Management</h4>
                </div>
                <div class="text-dark fw-bold">Super Admin</div>
            </nav>

            <div class="widget-card-admin">
                <ul class="nav nav-tabs custom-tabs mb-4" id="aboutTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#aboutContent">About EEPROM</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#visionContent">Visi Misi & Motto</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#divisionContent">Divisi</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#achieveContent">Achievements</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="aboutContent">
                        <form action="process_about.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Tentang EEPROM</label>
                                <textarea name="about_text" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sejarah</label>
                                <textarea name="history_text" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Tahun Berdiri</label>
                                <input name="established_year" type="number" class="form-control" style="width: 150px;" value="2015">
                            </div>
                            <button type="submit" class="btn btn-accent px-4">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/about/index.js"></script>
</body>

</html>