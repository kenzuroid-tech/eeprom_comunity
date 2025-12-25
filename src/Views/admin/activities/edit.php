<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Aktivitas - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/imgages/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/activities/edit.css">
    
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Edit Aktivitas</h4>
                </div>
                <div class="text-muted small">Activity ID: #ACT-2024-001</div>
            </nav>

            <form>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="widget-card-admin shadow-sm">
                            <div class="mb-4">
                                <label class="form-label">Judul Aktivitas</label>
                                <input type="text" class="form-control" id="titleInput" value="Workshop Robotika Nasional 2024" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Slug (Auto-generated)</label>
                                <input type="text" class="form-control" id="slugInput" value="workshop-robotika-nasional-2024">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Deskripsi Singkat (Max 200 Karakter)</label>
                                <textarea class="form-control" id="shortDesc" rows="2" maxlength="200">Workshop berskala nasional yang membahas tentang pengembangan sistem robotika berbasis IoT dan AI.</textarea>
                                <div class="text-end small text-muted" id="charCount">0/200</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Deskripsi Lengkap</label>
                                <div class="border rounded p-2 bg-light mb-2"><small><i class="bi bi-info-circle me-1"></i> Rich Text Editor Placeholder</small></div>
                                <textarea class="form-control" rows="10">Workshop ini akan menghadirkan pembicara ahli di bidang robotika. Peserta akan belajar merakit robot dari awal hingga tahap pemrograman sistem kendali jarak jauh...</textarea>
                            </div>
                        </div>

                        <div class="widget-card-admin shadow-sm">
                            <h5 class="fw-bold mb-4">Gallery Images</h5>
                            <input type="file" class="form-control mb-3" multiple>
                            <div class="gallery-grid">
                                <div class="gallery-item">
                                    <!-- <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=200" alt="Gallery"> -->
                                    <button type="button" class="btn-remove-img"><i class="bi bi-x"></i></button>
                                </div>
                                <div class="gallery-item">
                                    <!-- <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=200" alt="Gallery"> -->
                                    <button type="button" class="btn-remove-img"><i class="bi bi-x"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="widget-card-admin shadow-sm">
                            <h5 class="fw-bold mb-4">Featured Image</h5>
                            <div class="preview-container">
                                <!-- <img src="https://images.unsplash.com/photo-1531297484001-80022131f5a1?auto=format&fit=crop&q=80&w=600" id="imgPreview" alt="Featured"> -->
                            </div>
                            <input type="file" class="form-control" id="imgInput">
                        </div>

                        <div class="widget-card-admin shadow-sm">
                            <h5 class="fw-bold mb-4">Detail Pelaksanaan</h5>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select">
                                    <option value="Workshop" selected>Workshop/Seminar</option>
                                    <option value="Competition">Competition</option>
                                    <option value="Social">Social Project</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" value="2024-05-20">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" class="form-control" value="Gedung Sipil Lt. 3, Polinema">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-update w-100">Update Activity</button>
                            <button type="button" class="btn btn-delete w-100" onclick="confirmDelete()">Delete Activity</button>
                            <a href="/admin/activities/index.php" class="btn btn-cancel text-center">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/activities/edit.js"></script>
</body>
</html>