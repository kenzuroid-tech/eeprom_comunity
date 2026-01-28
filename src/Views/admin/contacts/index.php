<?php

/**
 * Data dari ContactController
 * @var array $messages       Daftar pesan masuk
 * @var array $mainContact     Data organisasi
 * @var array $contactPersons  Daftar orang yang bisa dihubungi
 * @var array $adminData       Data profil admin
 */
$messages = $messages ?? [];
$mainContact = $mainContact ?? [];
$contactPersons = $contactPersons ?? [];

$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : '/assets/images/default-avatar.png';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management - EEPROM Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <style>
        :root {
            --primary-blue: #1A237E;
            --accent-orange: #FF5722;
            --bg-gray: #F1F5F9;
            --sidebar-width: 280px;
        }

        body {
            background-color: var(--bg-gray);
            font-family: 'Poppins', sans-serif;
            color: #334155;
        }

        /* --- Layout Adjustment agar tidak tertutup Sidebar --- */
        .main-content-area {
            margin-left: calc(var(--sidebar-width) + 20px);
            padding: 30px;
            transition: 0.3s;
            min-height: 100vh;
        }

        .navbar {
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .widget-card-admin {
            background: white;
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .nav-tabs {
            border-bottom: 2px solid #F1F5F9;
            gap: 15px;
            background: transparent;
            margin-bottom: 2rem !important;
        }

        .nav-tabs .nav-link {
            border: none !important;
            color: #64748B !important;
            font-weight: 600;
            padding: 12px 25px;
            border-radius: 12px 12px 0 0;
            transition: 0.3s;
            background: none !important;
        }

        .nav-tabs .nav-link.active {
            color: #1A237E !important;
            background-color: rgba(255, 87, 34, 0.05) !important;
            position: relative;
            box-shadow: none !important;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: #FF5722;
            border-radius: 10px;
        }

        .nav-tabs .nav-link:hover {
            color: #FF5722 !important;
            background-color: #F8FAFC !important;
        }

        .form-label {
            color: #334155 !important;
            font-weight: 600 !important;
        }

        /* --- Table & Badges --- */
        .table thead th {
            background-color: #F8FAFC;
            color: #64748B;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 15px;
        }

        .status-badge {
            font-size: 0.7rem;
            padding: 5px 12px;
            border-radius: 10px;
            font-weight: 700;
        }

        .cp-photo {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #F1F5F9;
        }

        /* --- Forms --- */
        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 12px 15px;
            background-color: #F8FAFC;
            border: 1px solid #E2E8F0;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
        }

        .btn-success {
            background-color: #10B981;
            border: none;
            border-radius: 10px;
        }

        @media (max-width: 991.98px) {
            .main-content-area {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded-4 shadow-sm mb-4 px-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-primary border-0 me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list fs-3"></i></button>
                    <h4 class="m-0 fw-bold text-dark">Contact Management</h4>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>" width="38" height="38" class="rounded-circle me-2" style="object-fit: cover; border: 2px solid var(--primary-blue); padding: 2px;">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                        <li><a class="dropdown-item py-2" href="/member/profile"><i class="bi bi-person me-2 text-primary"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="widget-card-admin">
                <ul class="nav nav-tabs mb-5" id="contactTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#inbox"></i>Inbox Messages</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#mainContact"></i>Main Contact</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contactPersons"></i>Contact Persons</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="inbox">
                        <div class="table-responsive rounded-4 border overflow-hidden">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Pengirim</th>
                                        <th>Subjek</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($messages)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">Belum ada pesan masuk.</td>
                                        </tr>
                                        <?php else: foreach ($messages as $msg): ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($msg['name']) ?></div>
                                                    <small class="text-muted"><?= htmlspecialchars($msg['email']) ?></small>
                                                </td>
                                                <td><span class="text-dark fw-medium"><?= htmlspecialchars($msg['subject']) ?></span></td>
                                                <td>
                                                    <span class="status-badge bg-<?= $msg['status'] == 'unread' ? 'warning-subtle text-warning' : 'light text-muted' ?> border">
                                                        <?= strtoupper($msg['status']) ?>
                                                    </span>
                                                </td>
                                                <td><small class="text-muted"><?= date('d M Y', strtotime($msg['created_at'])) ?></small></td>
                                                <td class="text-center pe-4">
                                                    <div class="btn-group shadow-sm rounded-pill overflow-hidden bg-white border">
                                                        <button class="btn btn-sm btn-white text-primary border-end" onclick="viewMessage(<?= htmlspecialchars(json_encode($msg)) ?>)"><i class="bi bi-eye-fill"></i></button>
                                                        <a href="/admin/contacts/delete?id=<?= $msg['id'] ?>" class="btn btn-sm btn-white text-danger" onclick="return confirm('Hapus pesan ini?')"><i class="bi bi-trash-fill"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php endforeach;
                                    endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="mainContact">
                        <form action="/admin/contacts/update-main" method="POST">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Alamat Organisasi</label>
                                    <textarea name="address" class="form-control" rows="4" placeholder="Alamat Sekretariat..."><?= $mainContact['address'] ?? '' ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Google Maps Embed Code</label>
                                    <textarea name="maps_code" class="form-control" rows="4" placeholder='<iframe src="..."></iframe>'><?= $mainContact['maps_code'] ?? '' ?></textarea>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small text-muted">Email Resmi</label>
                                    <input type="email" name="email" class="form-control" value="<?= $mainContact['email'] ?? '' ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small text-muted">Telepon</label>
                                    <input type="text" name="phone" class="form-control" value="<?= $mainContact['phone'] ?? '' ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small text-muted">WhatsApp</label>
                                    <input type="text" name="whatsapp" class="form-control" value="<?= $mainContact['whatsapp'] ?? '' ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold small text-muted">Instagram ID</label>
                                    <input type="text" name="instagram" class="form-control" value="<?= $mainContact['instagram'] ?? '' ?>">
                                </div>
                            </div>
                            <div class="mt-5 text-end">
                                <button type="submit" class="btn btn-primary shadow">Simpan Perubahan Kontak</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="contactPersons">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0 text-dark">List Pengelola Kontak</h5>
                            <button class="btn btn-success fw-bold px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalCP">
                                <i class="bi bi-plus-lg me-2"></i>Tambah CP Baru
                            </button>
                        </div>
                        <div class="table-responsive rounded-4 border overflow-hidden">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">No</th>
                                        <th>Profil</th>
                                        <th>Jabatan</th>
                                        <th>Informasi Kontak</th>
                                        <th class="text-center pe-4">Kelola</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contactPersons as $cp): ?>
                                        <tr>
                                            <td class="ps-4 text-muted small">#<?= $cp['sort_order'] ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= $cp['photo_url'] ?: '/assets/images/default-avatar.png' ?>" class="cp-photo me-3 shadow-sm">
                                                    <span class="fw-bold text-dark"><?= htmlspecialchars($cp['name']) ?></span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill"><?= htmlspecialchars($cp['position']) ?></span></td>
                                            <td>
                                                <div class="small"><i class="bi bi-envelope me-1 text-muted"></i> <?= $cp['email'] ?></div>
                                                <div class="small"><i class="bi bi-whatsapp me-1 text-success"></i> <?= $cp['phone'] ?></div>
                                            </td>
                                            <td class="text-center pe-4">
                                                <div class="btn-group shadow-sm rounded-pill overflow-hidden bg-white border">
                                                    <button class="btn btn-sm btn-white text-warning border-end" onclick="editCP(<?= htmlspecialchars(json_encode($cp)) ?>)"><i class="bi bi-pencil-square"></i></button>
                                                    <a href="/admin/contacts/delete-cp?id=<?= $cp['id'] ?>" class="btn btn-sm btn-white text-danger" onclick="return confirm('Hapus CP ini?')"><i class="bi bi-trash-fill"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalView" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 bg-light p-4 rounded-top-4">
                    <h5 class="modal-title fw-bold text-dark">Detail Pesan Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary-subtle p-3 rounded-circle me-3 text-primary"><i class="bi bi-person-circle fs-3"></i></div>
                        <div>
                            <strong id="viewName" class="d-block fs-5"></strong>
                            <small id="viewEmail" class="text-muted"></small>
                        </div>
                    </div>
                    <div class="mb-2 small text-muted text-uppercase fw-bold letter-spacing-1">Subjek:</div>
                    <p id="viewSubject" class="fw-bold text-dark mb-4 fs-6"></p>
                    <hr class="opacity-10 mb-4">
                    <div class="p-3 bg-light rounded-3" id="viewMessageContent" style="white-space: pre-wrap; line-height: 1.6;"></div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCP" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/admin/contacts/save-cp" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 bg-light p-4">
                    <h5 class="modal-title fw-bold" id="cpModalTitle">Tambah Pengelola Kontak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="cpId">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Foto Profil</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Lengkap</label>
                        <input type="text" name="name" id="cpName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Jabatan / Peran</label>
                        <input type="text" name="position" id="cpPosition" class="form-control" placeholder="Contoh: Admin Pendaftaran" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Email</label>
                            <input type="email" name="email" id="cpEmail" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Phone/WhatsApp</label>
                            <input type="text" name="phone" id="cpPhone" class="form-control">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small">Urutan Tampil (Sort Order)</label>
                        <input type="number" name="sort_order" id="cpOrder" class="form-control" value="0">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow">Simpan Data CP</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewMessage(data) {
            document.getElementById('viewName').innerText = data.name;
            document.getElementById('viewEmail').innerText = data.email;
            document.getElementById('viewSubject').innerText = data.subject;
            document.getElementById('viewMessageContent').innerText = data.message;
            new bootstrap.Modal(document.getElementById('modalView')).show();
        }

        function editCP(data) {
            document.getElementById('cpModalTitle').innerText = "Edit Contact Person";
            document.getElementById('cpId').value = data.id;
            document.getElementById('cpName').value = data.name;
            document.getElementById('cpPosition').value = data.position;
            document.getElementById('cpEmail').value = data.email;
            document.getElementById('cpPhone').value = data.phone;
            document.getElementById('cpOrder').value = data.sort_order;
            new bootstrap.Modal(document.getElementById('modalCP')).show();
        }
    </script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>