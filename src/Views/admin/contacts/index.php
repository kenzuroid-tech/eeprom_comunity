<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/img/eeprom logo.png" type="image/png">
    
    <link rel="stylesheet" href="/public/assets/css/admin/contact/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Contact Management</h4>
                </div>
            </nav>

            <ul class="nav nav-tabs" id="contactTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="main-tab" data-bs-toggle="tab" data-bs-target="#main-contact" type="button">Main Contact</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="persons-tab" data-bs-toggle="tab" data-bs-target="#contact-persons" type="button">Contact Persons</button>
                </li>
            </ul>

            <div class="tab-content" id="contactTabsContent">
                <div class="tab-pane fade show active" id="main-contact">
                    <div class="widget-card-admin shadow-sm">
                        <form>
                            <div class="row g-4">
                                <div class="col-12">
                                    <h5 class="fw-bold border-bottom pb-2 mb-3">General Information</h5>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" rows="4" placeholder="Alamat Sekretariat..."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Google Maps Embed Code</label>
                                    <textarea class="form-control" rows="4" placeholder="Paste iframe code here..."></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="eeprom@polinema.ac.id">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" placeholder="(0341) 123456">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">WhatsApp Number</label>
                                    <input type="text" class="form-control" placeholder="08123456789">
                                </div>

                                <div class="col-12 mt-5">
                                    <h5 class="fw-bold border-bottom pb-2 mb-3">Social Media Links</h5>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label class="form-label"><i class="bi bi-instagram me-1"></i> Instagram</label>
                                    <input type="url" class="form-control" placeholder="https://instagram.com/...">
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label class="form-label"><i class="bi bi-facebook me-1"></i> Facebook (Optional)</label>
                                    <input type="url" class="form-control" placeholder="https://facebook.com/...">
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label class="form-label"><i class="bi bi-twitter-x me-1"></i> Twitter (Optional)</label>
                                    <input type="url" class="form-control" placeholder="https://twitter.com/...">
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <label class="form-label"><i class="bi bi-linkedin me-1"></i> LinkedIn</label>
                                    <input type="url" class="form-control" placeholder="https://linkedin.com/in/...">
                                </div>

                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-save shadow">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="contact-persons">
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-add shadow-sm" data-bs-toggle="modal" data-bs-target="#modalContactPerson">
                            <i class="bi bi-person-plus-fill me-2"></i>Tambah Contact Person
                        </button>
                    </div>

                    <div class="widget-card-admin p-0 overflow-hidden shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th width="50"></th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th class="text-center">Urutan</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-table">
                                    <tr>
                                        <td class="text-center"><i class="bi bi-grip-vertical handle"></i></td>
                                        <td><img src="https://ui-avatars.com/api/?name=Reza+Aditya&background=1A237E&color=fff" class="rounded-circle" width="35"></td>
                                        <td class="fw-bold">Reza Aditya</td>
                                        <td>Ketua Umum</td>
                                        <td>reza@eeprom.com</td>
                                        <td>08123456789</td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light text-primary me-1"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><i class="bi bi-grip-vertical handle"></i></td>
                                        <td><img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=FF5722&color=fff" class="rounded-circle" width="35"></td>
                                        <td class="fw-bold">Siti Aminah</td>
                                        <td>Sekretaris</td>
                                        <td>siti@eeprom.com</td>
                                        <td>08987654321</td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light text-primary me-1"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p class="small text-muted mt-2"><i class="bi bi-info-circle me-1"></i>Gunakan ikon grip di sebelah kiri untuk mengubah urutan tampilan (Drag & Drop).</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalContactPerson" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-primary">Form Contact Person</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Upload Foto</label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-control" placeholder="Contoh: Ketua Umum / Hubungan Masyarakat">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="nama@email.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone/WhatsApp</label>
                                <input type="text" class="form-control" placeholder="08...">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urutan Tampilan</label>
                            <input type="number" class="form-control" value="1">
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-save">Save Contact Person</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/contact/index.js"></script>
</body>
</html>