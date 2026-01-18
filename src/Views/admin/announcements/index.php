<?php

/**
 * File: src/Views/admin/announcements/index.php
 */
// Pastikan variabel ini dikirim dari Controller
$announcements = $announcements ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements Management - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/admin/announcements/index.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div id="mainContentWrapper" class="main-content-area">
            <nav class="top-navbar d-flex justify-content-between align-items-center p-3 shadow-sm bg-white">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Announcements Management</h4>
                </div>
                <a href="/admin/announcements/create" class="btn btn-primary shadow-sm text-decoration-none bg-orange border-0">
                    <i class="bi bi-plus-lg me-2"></i>Buat Pengumuman
                </a>
            </nav>

                <div class="widget-card-admin bg-white p-4 rounded shadow-sm mb-4">
                    <h6 class="mb-3 fw-bold text-primary"><i class="bi bi-funnel me-2"></i>Filter Pengumuman</h6>
                    <form class="row g-3" method="GET" action="/admin/announcements">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Tipe Pengumuman</label>
                            <select name="category" class="form-select border-0 bg-light">
                                <option value="">Semua Tipe</option>
                                <option value="info" <?= ($_GET['category'] ?? '') == 'info' ? 'selected' : '' ?>>Informasi Umum</option>
                                <option value="urgent" <?= ($_GET['category'] ?? '') == 'urgent' ? 'selected' : '' ?>>Urgent / Penting</option>
                                <option value="event" <?= ($_GET['category'] ?? '') == 'event' ? 'selected' : '' ?>>Event / Kegiatan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Status Publikasi</label>
                            <select name="status_filter" class="form-select border-0 bg-light">
                                <option value="">Semua Status</option>
                                <option value="published" <?= ($_GET['status_filter'] ?? '') == 'published' ? 'selected' : '' ?>>Published</option>
                                <option value="draft" <?= ($_GET['status_filter'] ?? '') == 'draft' ? 'selected' : '' ?>>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Terapkan Filter</button>
                            <a href="/admin/announcements" class="btn btn-light border w-50 fw-bold">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="widget-card-admin bg-white rounded shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Judul Pengumuman</th>
                                    <th>Tipe</th>
                                    <th>Status</th>
                                    <th>Published At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($announcements)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-megaphone fs-1 d-block mb-2"></i>
                                            Belum ada pengumuman yang sesuai dengan filter.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($announcements as $item): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold text-dark"><?= htmlspecialchars($item['title']) ?></div>
                                                <small class="text-muted text-truncate d-block" style="max-width: 300px;">
                                                    <?= substr(strip_tags($item['content']), 0, 50) ?>...
                                                </small>
                                            </td>
                                            <td>
                                                <?php
                                                $typeClass = [
                                                    'info' => 'bg-info-subtle text-info',
                                                    'urgent' => 'bg-danger-subtle text-danger',
                                                    'event' => 'bg-primary-subtle text-primary'
                                                ];
                                                // Gunakan strtolower agar pengecekan case-insensitive
                                                $class = $typeClass[strtolower($item['category'])] ?? 'bg-secondary-subtle text-secondary';
                                                ?>
                                                <span class="badge <?= $class ?> text-capitalize px-3 py-2">
                                                    <?= htmlspecialchars($item['category']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (strtolower($item['status'] ?? 'draft') == 'published'): ?>
                                                    <span class="badge-status-dot bg-success"></span>
                                                    <small class="fw-bold text-success">Published</small>
                                                <?php else: ?>
                                                    <span class="badge-status-dot bg-secondary"></span>
                                                    <small class="fw-bold text-secondary">Draft</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= date('d M Y, H:i', strtotime($item['created_at'])) ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group shadow-sm border rounded-2 bg-white">
                                                    <a href="/admin/announcements/edit?id=<?= $item['id'] ?>" class="btn btn-sm px-3" title="Edit">
                                                        <i class="bi bi-pencil-square text-warning"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm px-3 border-start" title="Delete"
                                                        onclick="confirmDelete(<?= $item['id'] ?>)">
                                                        <i class="bi bi-trash text-danger"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="p-3 border-top bg-light d-flex justify-content-between align-items-center">
                        <small class="text-muted">Total: <?= count($announcements) ?> Pengumuman</small>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')) {
                // Pastikan rute ini ada di index.php (Router)
                window.location.href = '/admin/announcements/delete?id=' + id;
            }
        }
    </script>
    <script src="/assets/js/admin/dashboard.js"></script>
</body>

</html>