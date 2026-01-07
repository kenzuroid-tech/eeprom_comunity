<?php

/**
 * File: src/Views/admin/meetings/attendance-input.php
 */
$adminData = $adminData ?? [];
$meeting = $meeting ?? [];
$attendanceList = $attendanceList ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Attendance - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <link rel="stylesheet" href="/assets/css/admin/attendance/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">

            <nav class="top-navbar d-flex justify-content-between align-items-center p-3">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Input Absensi Rapat</h4>
                </div>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?= $adminData['foto_url'] ?? 'https://ui-avatars.com/api/?name=Admin' ?>" alt="Profile" width="35" class="rounded-circle me-2">
                        <span class="d-none d-sm-inline text-dark fw-bold"><?= $adminData['nama_lengkap'] ?? 'Admin' ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </nav>

            <div class="info-header shadow-sm p-4 bg-primary text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <span class="badge bg-white text-primary mb-2">ID Rapat: #MTG-<?= $meeting['id'] ?></span>
                        <h2 class="fw-bold mb-1"><?= htmlspecialchars($meeting['title']) ?></h2>
                        <p class="m-0 opacity-75">
                            <i class="bi bi-calendar3 me-2"></i> <?= date('l, d F Y', strtotime($meeting['date'])) ?> |
                            <i class="bi bi-geo-alt me-2"></i> <?= htmlspecialchars($meeting['location']) ?>
                        </p>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs nav-tabs-custom px-4" id="attendanceTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button"><i class="bi bi-pencil-square me-2"></i>Manual Input</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="qr-tab" data-bs-toggle="tab" data-bs-target="#qr" type="button"><i class="bi bi-qr-code-scan me-2"></i>Scan QR Code</button>
                </li>
            </ul>

            <div class="tab-content p-4">
                <div class="tab-pane fade show active" id="manual">
                    <div class="widget-card-admin bg-white p-4 rounded shadow-sm">
                        <form action="/admin/attendance/update" method="POST">
                            <input type="hidden" name="meeting_id" value="<?= $meeting['id'] ?>">

                            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                <h5 class="fw-bold m-0 text-primary">Daftar Anggota Komunitas EEPROM</h5>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="setStatusAll('Hadir')">Set Hadir Semua</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="setStatusAll('Alpa')">Set Alpa Semua</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Anggota</th>
                                            <th>NIM</th>
                                            <th width="300">Status</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($attendanceList as $index => $row): ?>
                                            <?php
                                            // Jika data belum ada di tabel attendance, gunakan user_id sebagai key
                                            $identifier = $row['attendance_id'] ?? 'new_' . $row['user_id'];
                                            ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= !empty($row['foto_url']) ? $row['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($row['nama_lengkap']) ?>"
                                                            class="rounded-circle me-3" width="35" height="35" style="object-fit: cover;">
                                                        <span class="fw-bold"><?= htmlspecialchars($row['nama_lengkap']) ?></span>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($row['nim']) ?></td>
                                                <td>
                                                    <div class="btn-group w-100" role="group">
                                                        <input type="radio" class="btn-check status-radio"
                                                            name="attendance[<?= $identifier ?>][status]" value="Hadir"
                                                            id="h<?= $identifier ?>" <?= $row['status'] == 'Hadir' ? 'checked' : '' ?>>
                                                        <label class="btn btn-outline-success btn-sm" for="h<?= $identifier ?>">Hadir</label>

                                                        <input type="radio" class="btn-check status-radio"
                                                            name="attendance[<?= $identifier ?>][status]" value="Alpa"
                                                            id="a<?= $identifier ?>" <?= ($row['status'] == 'Alpa' || empty($row['status'])) ? 'checked' : '' ?>>
                                                        <label class="btn btn-outline-danger btn-sm" for="a<?= $identifier ?>">Alpa</label>

                                                        <input type="radio" class="btn-check status-radio"
                                                            name="attendance[<?= $identifier ?>][status]" value="Izin"
                                                            id="i<?= $identifier ?>" <?= $row['status'] == 'Izin' ? 'checked' : '' ?>>
                                                        <label class="btn btn-outline-warning btn-sm" for="i<?= $identifier ?>">Izin</label>
                                                    </div>
                                                    <input type="hidden" name="attendance[<?= $identifier ?>][user_id]" value="<?= $row['user_id'] ?>">
                                                </td>
                                                <td>
                                                    <input type="text" name="attendance[<?= $identifier ?>][remarks]"
                                                        class="form-control form-control-sm" placeholder="Opsional"
                                                        value="<?= htmlspecialchars($row['remarks'] ?? '') ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-orange px-5 py-2 shadow-sm text-white fw-bold"><i class="bi bi-save me-2"></i>Simpan Absensi</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="qr">
                    <div class="row g-4">
                        <div class="col-lg-5 text-center">
                            <div class="widget-card-admin bg-white p-4 rounded shadow-sm h-100">
                                <h5 class="fw-bold mb-3">QR Code Meeting</h5>
                                <div class="qr-placeholder mb-4 p-3 bg-white border rounded shadow-sm d-inline-block">
                                    <?php if (!empty($meeting['id'])): ?>
                                        <?php
                                        // URL yang akan di-scan oleh anggota (Sesuaikan dengan domain Anda nanti)
                                        $baseUrl = "http://eeprom.id/scan";
                                        $qrData = $baseUrl . "?mtg_id=" . $meeting['id'];
                                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrData);
                                        ?>
                                        <img src="<?= $qrUrl ?>" alt="QR Code Rapat" style="width: 200px; height: 200px;">
                                    <?php else: ?>
                                        <div class="alert alert-danger">ID Rapat tidak ditemukan!</div>
                                    <?php endif; ?>
                                </div>
                                <div class="alert alert-info py-2 small mb-4">
                                    <i class="bi bi-info-circle-fill me-2"></i>Anggota scan QR ini untuk absen otomatis
                                </div>
                                <p class="small text-muted mb-0">Meeting URL:</p>
                                <code class="d-block mb-3">eeprom.id/scan?mtg_id=<?= $meeting['id'] ?></code>
                                <button class="btn btn-outline-primary btn-sm"><i class="bi bi-download me-2"></i>Unduh QR</button>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="widget-card-admin bg-white p-4 rounded shadow-sm h-100">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-bold m-0"><i class="bi bi-broadcast text-danger me-2"></i>Real-time Attendance</h5>
                                    <span class="badge bg-success">Auto-refresh Active</span>
                                </div>
                                <div class="list-group list-group-flush border rounded" style="max-height: 400px; overflow-y: auto;">
                                    <?php
                                    $presentCount = 0;
                                    foreach ($attendanceList as $row):
                                        if ($row['status'] == 'Hadir'):
                                            $presentCount++;
                                    ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-img bg-primary-subtle d-flex align-items-center justify-content-center me-3 rounded-circle" style="width:40px; height:40px;">
                                                        <i class="bi bi-person text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?= htmlspecialchars($row['nama_lengkap']) ?></div>
                                                        <small class="text-muted">NIM: <?= htmlspecialchars($row['nim']) ?></small>
                                                    </div>
                                                </div>
                                                <span class="badge bg-light text-dark border fw-normal"><?= $row['created_at'] ?? date('H:i') ?></span>
                                            </div>
                                    <?php endif;
                                    endforeach; ?>
                                </div>
                                <div class="mt-3 text-center">
                                    <p class="small text-muted m-0">Total Hadir: <?= $presentCount ?> Anggota</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi JS untuk set status semua radio button secara cepat
        function setStatusAll(status) {
            const radios = document.querySelectorAll('.status-radio');
            radios.forEach(radio => {
                if (radio.value === status) {
                    radio.checked = true;
                }
            });
        }
    </script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>