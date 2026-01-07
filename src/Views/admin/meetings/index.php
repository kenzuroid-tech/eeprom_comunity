<?php

/**
 * File: src/Views/admin/meetings/index.php
 */
$adminData = $adminData ?? [];
$meetings = $meetings ?? [];
$today = date('Y-m-d');

// Memisahkan rapat berdasarkan waktu
$upcomingMeetings = array_filter($meetings, function ($m) use ($today) {
    return $m['date'] >= $today;
});

$pastMeetings = array_filter($meetings, function ($m) use ($today) {
    return $m['date'] < $today;
});
$adminFotoNavbar = !empty($adminData['foto_url']) ? $adminData['foto_url'] : 'https://ui-avatars.com/api/?name=' . urlencode($adminData['nama_lengkap'] ?? 'Admin');

$adminData = $adminData ?? [];
$meetings = $meetings ?? [];
$allMembers = $allMembers ?? []; // Variabel baru untuk dropdown laporan
$today = date('Y-m-d');

// Filter Rapat
$upcomingMeetings = array_filter($meetings, function ($m) use ($today) {
    return $m['date'] >= $today;
});

$pastMeetings = array_filter($meetings, function ($m) use ($today) {
    return $m['date'] < $today;
});
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting & Attendance - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin/meetings/index.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area p-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-3 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold text-primary">Meetings & Attendance</h4>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        id="adminDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="<?= htmlspecialchars($adminFotoNavbar) ?>"
                            alt="Profile"
                            width="35"
                            height="35"
                            class="rounded-circle me-2"
                            style="object-fit: cover; border: 1px solid #ddd;">
                        <span class="d-none d-sm-inline text-dark fw-bold">
                            <?= htmlspecialchars($adminData['nama_lengkap'] ?? 'Super Admin') ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="adminDropdown">
                        <li>
                            <a class="dropdown-item py-2" href="/member/profile">
                                <i class="bi bi-person me-2 text-primary"></i>Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger py-2" href="/logout">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="widget-card-admin bg-white p-4 rounded shadow-sm">
                <ul class="nav nav-tabs nav-tabs-custom mb-4" id="meetingTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button">Upcoming Meetings</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button">Past Meetings</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button">Attendance Reports</button>
                    </li>
                </ul>

                <div class="tab-content" id="meetingTabsContent">
                    <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold mb-0">Rapat Terjadwal</h6>
                            <a href="/admin/meetings/create" class="btn btn-orange btn-sm shadow-sm">
                                <i class="bi bi-calendar-plus me-2"></i>Jadwalkan Rapat Baru
                            </a>
                        </div>

                        <div class="row g-4">
                            <?php if (empty($upcomingMeetings)): ?>
                                <div class="col-12 text-center py-5">
                                    <img src="/assets/images/empty_state.svg" width="150" class="mb-3 opacity-50">
                                    <p class="text-muted">Tidak ada rapat mendatang.</p>
                                </div>
                                <?php else: foreach ($upcomingMeetings as $m): ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="meeting-card p-4 border rounded shadow-sm position-relative">
                                            <div class="d-flex justify-content-between mb-3">
                                                <span class="badge bg-primary-subtle text-primary rounded-pill">Koordinasi</span>
                                                <div class="dropdown">
                                                    <i class="bi bi-three-dots-vertical text-muted cursor-pointer" data-bs-toggle="dropdown"></i>
                                                    <ul class="dropdown-menu border-0 shadow-sm">
                                                        <li><a class="dropdown-item" href="/admin/meetings/edit?id=<?= $m['id'] ?>">Edit</a></li>
                                                        <li><a class="dropdown-item text-danger" href="/admin/meetings/delete?id=<?= $m['id'] ?>">Hapus</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <h5 class="fw-bold mb-3"><?= htmlspecialchars($m['title']) ?></h5>
                                            <ul class="list-unstyled small text-muted mb-4">
                                                <li class="mb-2"><i class="bi bi-calendar-event me-2"></i><?= date('D, d M Y', strtotime($m['date'])) ?></li>
                                                <li class="mb-2"><i class="bi bi-clock me-2"></i><?= date('H:i', strtotime($m['start_time'])) ?> WIB</li>
                                                <li class="mb-2"><i class="bi bi-geo-alt me-2"></i><?= htmlspecialchars($m['location']) ?></li>
                                            </ul>
                                            <div class="d-grid gap-2">
                                                <a href="/admin/attendance/input?id=<?= $m['id'] ?>" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-qr-code-scan me-2"></i>Input Attendance
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach;
                            endif; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="past" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul Rapat</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <?php foreach ($pastMeetings as $pm): ?>
                                        <tr>
                                            <td class="fw-bold"><?= htmlspecialchars($pm['title']) ?></td>
                                            <td><?= date('d M Y', strtotime($pm['date'])) ?></td>
                                            <td><?= htmlspecialchars($pm['location']) ?></td>
                                            <td>
                                                <a href="/admin/attendance/report?id=<?= $pm['id'] ?>" class="btn btn-light btn-sm border"><i class="bi bi-eye"></i> View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="reports" role="tabpanel">
                        <div class="row mb-5 g-4">
                            <div class="col-lg-4">
                                <label class="small fw-bold mb-2">Cari Anggota</label>
                                <form action="/admin/meetings/search-report" method="GET">
                                    <select name="user_id" class="form-select mb-4 shadow-sm" required>
                                        <option value="" selected disabled>Pilih Nama Anggota...</option>

                                        <?php if (!empty($allMembers)): ?>
                                            <?php foreach ($allMembers as $member): ?>
                                                <option value="<?= $member['user_id'] ?>">
                                                    <?= htmlspecialchars($member['nama_lengkap']) ?> (<?= $member['nim'] ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option disabled>Data anggota tidak tersedia</option>
                                        <?php endif; ?>

                                    </select>
                                    <button type="submit" class="btn btn-orange w-100 shadow-sm">
                                        <i class="bi bi-file-earmark-arrow-down me-2"></i>Export Report
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>