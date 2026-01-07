<?php

/**
 * Data dari ContactController
 * @var array $messages       Daftar pesan masuk
 * @var array $mainContact    Data dari tabel organization_contact (address, email, dsb)
 * @var array $contactPersons Daftar orang yang bisa dihubungi
 * @var array $adminData      Data profil admin
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
    <title>Contact Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <style>
        :root {
            --primary-blue: #1A237E;
            --accent-orange: #FF5722;
        }

        .main-content-area {
            padding: 30px;
            transition: 0.3s;
        }

        .widget-card-admin {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .nav-tabs .nav-link {
            color: #666;
            font-weight: 600;
            border: none;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-blue);
            border-bottom: 3px solid var(--primary-blue);
            background: none;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .cp-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Contact Management</h4>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>" width="35" height="35" class="rounded-circle me-2">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="widget-card-admin">
                <ul class="nav nav-tabs mb-4" id="contactTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#inbox">Inbox Messages</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#mainContact">Main Contact</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contactPersons">Contact Persons</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="inbox">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pengirim</th>
                                        <th>Subjek</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($messages)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">Tidak ada pesan.</td>
                                        </tr>
                                        <?php else: foreach ($messages as $msg): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($msg['name']) ?></strong><br><small><?= htmlspecialchars($msg['email']) ?></small></td>
                                                <td><?= htmlspecialchars($msg['subject']) ?></td>
                                                <td><span class="status-badge bg-<?= $msg['status'] == 'unread' ? 'warning' : 'light' ?> border"><?= strtoupper($msg['status']) ?></span></td>
                                                <td><?= date('d M Y', strtotime($msg['created_at'])) ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary" onclick="viewMessage(<?= htmlspecialchars(json_encode($msg)) ?>)"><i class="bi bi-eye"></i></button>
                                                    <a href="/admin/contacts/delete?id=<?= $msg['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></a>
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
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <textarea name="address" class="form-control" rows="3"><?= $mainContact['address'] ?? '' ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Google Maps Embed Code</label>
                                    <textarea name="maps_code" class="form-control" rows="3" placeholder='<iframe src="..."></iframe>'><?= $mainContact['maps_code'] ?? '' ?></textarea>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $mainContact['email'] ?? '' ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?= $mainContact['phone'] ?? '' ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">WhatsApp</label>
                                    <input type="text" name="whatsapp" class="form-control" value="<?= $mainContact['whatsapp'] ?? '' ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Instagram</label>
                                    <input type="text" name="instagram" class="form-control" value="<?= $mainContact['instagram'] ?? '' ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary px-4 mt-2">Save Main Contact</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="contactPersons">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="fw-bold">List Contact Persons</h5>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalCP">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Contact Person
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Urutan</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Kontak</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="sortableCP">
                                    <?php foreach ($contactPersons as $cp): ?>
                                        <tr data-id="<?= $cp['id'] ?>">
                                            <td><i class="bi bi-grip-vertical me-2 text-muted"></i><?= $cp['sort_order'] ?></td>
                                            <td><img src="<?= $cp['photo_url'] ?: '/assets/images/default-avatar.png' ?>" class="cp-photo"></td>
                                            <td class="fw-bold"><?= htmlspecialchars($cp['name']) ?></td>
                                            <td><?= htmlspecialchars($cp['position']) ?></td>
                                            <td><small><?= $cp['email'] ?><br><?= $cp['phone'] ?></small></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-light text-warning" onclick="editCP(<?= htmlspecialchars(json_encode($cp)) ?>)"><i class="bi bi-pencil"></i></button>
                                                <a href="/admin/contacts/delete-cp?id=<?= $cp['id'] ?>" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></a>
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

    <div class="modal fade" id="modalCP" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/admin/contacts/save-cp" method="POST" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="cpModalTitle">Tambah Contact Person</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="cpId">
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" id="cpName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="position" id="cpPosition" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="cpEmail" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone/WA</label>
                            <input type="text" name="phone" id="cpPhone" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="sort_order" id="cpOrder" class="form-control" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan Contact Person</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalView" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Message Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-1"><small class="text-muted">Dari:</small><br><strong id="viewName"></strong> (<span id="viewEmail"></span>)</p>
                    <p class="mb-3"><small class="text-muted">Subjek:</small><br><span id="viewSubject"></span></p>
                    <hr>
                    <p class="mt-2" id="viewMessageContent" style="white-space: pre-wrap;"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // View Inbox Message
        function viewMessage(data) {
            document.getElementById('viewName').innerText = data.name;
            document.getElementById('viewEmail').innerText = data.email;
            document.getElementById('viewSubject').innerText = data.subject;
            document.getElementById('viewMessageContent').innerText = data.message;
            new bootstrap.Modal(document.getElementById('modalView')).show();
        }

        // Edit Contact Person
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
</body>

</html>