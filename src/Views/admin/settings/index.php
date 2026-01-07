<?php

/**
 * Data dari SettingsController
 * @var array $settings         Data dari tabel site_settings
 * @var array $admins           Daftar admin (users + members)
 * @var array $availableMembers Daftar anggota biasa (non-admin)
 * @var array $adminData        Data profil admin sedang login
 */
$settings = $settings ?? [];
$admins = $admins ?? [];
$availableMembers = $availableMembers ?? [];
$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : '/assets/images/default-avatar.png';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings - EEPROM POLINEMA</title>
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

        .nav-tabs .nav-link {
            color: #666;
            font-weight: 600;
            border: none;
            padding: 12px 20px;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-blue);
            border-bottom: 3px solid var(--primary-blue);
            background: none;
        }

        .widget-card-admin {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .btn-primary-eeprom {
            background-color: var(--primary-blue);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-accent-eeprom {
            background-color: var(--accent-orange);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
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
                    <h4 class="m-0 fw-bold text-dark">Website Settings</h4>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover; border: 1px solid #ddd;">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item py-2" href="/member/profile"><i class="bi bi-person me-2 text-primary"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger py-2" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general">General</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#user-mgmt">Admin Management</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#security">Security</button></li>
            </ul>

            <div class="tab-content" id="settingsTabsContent">
                <div class="tab-pane fade show active" id="general">
                    <div class="widget-card-admin shadow-sm">
                        <form action="/admin/settings/update-general" method="POST" enctype="multipart/form-data">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Site Name</label>
                                    <input type="text" name="site_name" class="form-control" value="<?= htmlspecialchars($settings['site_name'] ?? 'EEPROM POLINEMA') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Site Tagline</label>
                                    <input type="text" name="site_tagline" class="form-control" value="<?= htmlspecialchars($settings['site_tagline'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="form-check form-switch mt-3">
                                        <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenanceMode" <?= ($settings['maintenance_mode'] ?? false) ? 'checked' : '' ?>>
                                        <label class="form-check-label ms-2 fw-bold text-danger" for="maintenanceMode">Maintenance Mode</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary-eeprom px-4">Save General Settings</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="user-mgmt">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold m-0 text-primary">Admin Users List</h6>
                        <button class="btn btn-accent-eeprom btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddAdmin">
                            <i class="bi bi-person-plus-fill me-2"></i>Add Admin User
                        </button>
                    </div>
                    <div class="widget-card-admin p-0 overflow-hidden shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($admins as $admin): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold"><?= htmlspecialchars($admin['nama_lengkap']) ?></td>
                                            <td><?= htmlspecialchars($admin['email']) ?></td>
                                            <td><span class="badge bg-primary text-uppercase"><?= htmlspecialchars($admin['role']) ?></span></td>
                                            <td class="text-center">
                                                <a href="/admin/settings/delete-admin?id=<?= $admin['id'] ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Hapus akses admin ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="security">
                    <div class="col-lg-6">
                        <div class="widget-card-admin shadow-sm">
                            <h6 class="fw-bold mb-4">Change Admin Password</h6>
                            <form action="/admin/settings/change-password" method="POST">
                                <div class="mb-3"><label class="form-label">Current Password</label><input type="password" name="current_pw" class="form-control" required></div>
                                <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="new_pw" class="form-control" required></div>
                                <div class="mb-4"><label class="form-label">Confirm New Password</label><input type="password" name="confirm_pw" class="form-control" required></div>
                                <button type="submit" class="btn btn-accent-eeprom w-100">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddAdmin" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-primary">Add New Admin Access</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/admin/settings/add-admin" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Member</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Pilih Anggota --</option>
                                <?php if (!empty($availableMembers)): ?>
                                    <?php foreach ($availableMembers as $member): ?>
                                        <option value="<?= $member['id'] ?>">
                                            <?= htmlspecialchars($member['nama_lengkap']) ?> (<?= htmlspecialchars($member['nim']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>Semua anggota sudah menjadi admin</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Set Role</label>
                            <select name="role" class="form-select" required>
                                <option value="admin">Admin</option>
                                <option value="superadmin">Super Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-eeprom">Berikan Akses Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>