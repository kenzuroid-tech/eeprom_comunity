<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/img/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/public/assets/css/admin/settings/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        
        <div class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Website Settings</h4>
                </div>
            </nav>

            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general">General</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#user-mgmt">User Management</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#email-settings">Email Settings</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#security">Security</button></li>
            </ul>

            <div class="tab-content" id="settingsTabsContent">
                <div class="tab-pane fade show active" id="general">
                    <div class="widget-card-admin shadow-sm">
                        <form>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Site Name</label>
                                    <input type="text" class="form-control" value="EEPROM POLINEMA">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Site Tagline</label>
                                    <input type="text" class="form-control" value="Electrical and Electronics Engineering Polinema">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Upload Site Logo</label>
                                    <input type="file" class="form-control">
                                    <small class="text-muted">Recommended size: 512x512px (PNG/SVG)</small>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="form-check form-switch mt-3">
                                        <input class="form-check-input" type="checkbox" id="maintenanceMode">
                                        <label class="form-check-label ms-2 fw-bold text-danger" for="maintenanceMode">Maintenance Mode</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary-eeprom">Save General Settings</button>
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
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Super Admin</td>
                                        <td>superadmin@eeprom.com</td>
                                        <td><span class="badge bg-primary">Super Admin</span></td>
                                        <td>20 Jan 2024</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light text-primary me-1"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Admin Riset</td>
                                        <td>riset@eeprom.com</td>
                                        <td><span class="badge bg-secondary">Admin</span></td>
                                        <td>15 Feb 2024</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light text-primary me-1"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="email-settings">
                    <div class="widget-card-admin shadow-sm">
                        <h6 class="fw-bold mb-4">SMTP Configuration</h6>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-8"><label class="form-label">SMTP Host</label><input type="text" class="form-control" placeholder="smtp.gmail.com"></div>
                                <div class="col-md-4"><label class="form-label">SMTP Port</label><input type="text" class="form-control" placeholder="587"></div>
                                <div class="col-md-6"><label class="form-label">SMTP Username</label><input type="text" class="form-control"></div>
                                <div class="col-md-6"><label class="form-label">SMTP Password</label><input type="password" class="form-control"></div>
                                <div class="col-md-6"><label class="form-label">From Email</label><input type="email" class="form-control"></div>
                                <div class="col-md-6"><label class="form-label">From Name</label><input type="text" class="form-control"></div>
                                <div class="col-12 mt-4 d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary fw-bold"><i class="bi bi-send me-2"></i>Send Test Email</button>
                                    <button type="submit" class="btn btn-primary-eeprom">Save SMTP Settings</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="security">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="widget-card-admin shadow-sm">
                                <h6 class="fw-bold mb-4">Change Admin Password</h6>
                                <form>
                                    <div class="mb-3"><label class="form-label">Current Password</label><input type="password" class="form-control"></div>
                                    <div class="mb-3"><label class="form-label">New Password</label><input type="password" class="form-control"></div>
                                    <div class="mb-4"><label class="form-label">Confirm New Password</label><input type="password" class="form-control"></div>
                                    <button type="submit" class="btn btn-accent-eeprom w-100">Change Password</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="widget-card-admin shadow-sm">
                                <h6 class="fw-bold mb-3">Two-Factor Authentication</h6>
                                <div class="form-check form-switch mb-4">
                                    <input class="form-check-input" type="checkbox" id="2faToggle">
                                    <label class="form-check-label ms-2" for="2faToggle">Enable 2FA via Email</label>
                                </div>
                                <hr>
                                <h6 class="fw-bold mb-3">Login History (Last 5)</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm" style="font-size: 0.75rem;">
                                        <thead><tr><th>IP Address</th><th>Date</th><th>Device</th></tr></thead>
                                        <tbody>
                                            <tr><td>192.168.1.1</td><td>20 Dec 19:00</td><td>Chrome/Win10</td></tr>
                                            <tr><td>182.253.x.x</td><td>19 Dec 10:20</td><td>Firefox/Linux</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddAdmin" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light"><h5 class="modal-title fw-bold text-primary">Add New Admin</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-3"><label class="form-label">Name</label><input type="text" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">Role</label><select class="form-select"><option>Admin</option><option>Super Admin</option></select></div>
                        <div class="row">
                            <div class="col-6 mb-3"><label class="form-label">Password</label><input type="password" class="form-control" required></div>
                            <div class="col-6 mb-3"><label class="form-label">Confirm</label><input type="password" class="form-control" required></div>
                        </div>
                        <div class="d-grid mt-3"><button type="submit" class="btn btn-primary-eeprom">Create Admin Account</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/settings/index.js"></script>
</body>
</html>