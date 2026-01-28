<?php
$election = $election ?? [];
$codes = $codes ?? [];
$adminData = $adminData ?? [];

// Pisahkan kode berdasarkan tipe
$memberCodes = array_filter($codes, fn($c) => in_array($c['user_type'], ['anggota', 'alumni']));
$delegateCodes = array_filter($codes, fn($c) => $c['user_type'] === 'delegasi');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kode Akses - EEPROM Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin/voting/candidates.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <div class="main-content-area p-4">
            <nav class="top-navbar d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3 d-lg-none" id="mobile-toggle"><i class="bi bi-list"></i></button>
                    <h4 class="m-0 fw-bold">Kelola Kode Akses Voting</h4>
                </div>
                <div>
                    <a href="/admin/voting/print-vouchers?id=<?= $election['id'] ?>" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Cetak Voucher PDF
                    </a>
                    <button class="btn btn-orange rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#delegateModal">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Kode Manual
                    </button>
                </div>
            </nav>

            <!-- Info Pemilihan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-1"><?= htmlspecialchars($election['title'] ?? 'N/A') ?></h5>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-calendar-event me-1"></i>
                                <?= date('d M Y', strtotime($election['start_date'])) ?> - <?= date('d M Y', strtotime($election['end_date'])) ?>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <span class="badge bg-primary px-3 py-2">
                                Total: <?= count($codes) ?>
                            </span>
                            <span class="badge bg-success px-3 py-2 ms-2">
                                Terpakai: <?= count(array_filter($codes, fn($c) => $c['is_used'])) ?>
                            </span>
                            <span class="badge bg-info px-3 py-2 ms-2">
                                Delegasi: <?= count($delegateCodes) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-all" type="button">
                        <i class="bi bi-list-ul me-1"></i> Semua Kode (<?= count($codes) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-member" type="button">
                        <i class="bi bi-people me-1"></i> Member/Alumni (<?= count($memberCodes) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-delegasi" type="button">
                        <i class="bi bi-person-badge me-1"></i> Delegasi (<?= count($delegateCodes) ?>)
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Semua Kode -->
                <div class="tab-pane fade show active" id="tab-all">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kode Akses</th>
                                            <th>Nama</th>
                                            <th>Identitas</th>
                                            <th>Asal/Divisi</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($codes)): ?>
                                            <?php foreach ($codes as $c):
                                                $metadata = !empty($c['voter_metadata']) ? json_decode($c['voter_metadata'], true) : null;
                                                $origin = $metadata['origin'] ?? '-';
                                            ?>
                                                <tr>
                                                    <td>
                                                        <code class="bg-light p-2 rounded"><?= htmlspecialchars($c['code']) ?></code>
                                                        <button class="btn btn-sm btn-link" onclick="copyCode('<?= $c['code'] ?>')">
                                                            <i class="bi bi-clipboard"></i>
                                                        </button>
                                                    </td>
                                                    <td class="fw-bold"><?= htmlspecialchars($c['voter_name']) ?></td>
                                                    <td><?= htmlspecialchars($c['voter_identifier'] ?? '-') ?></td>
                                                    <td>
                                                        <?php if ($c['user_type'] === 'delegasi'): ?>
                                                            <span class="badge bg-info"><?= htmlspecialchars($origin) ?></span>
                                                        <?php else: ?>
                                                            <?= htmlspecialchars($origin) ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($c['user_type'] === 'delegasi'): ?>
                                                            <span class="badge bg-warning">Delegasi</span>
                                                        <?php elseif ($c['user_type'] === 'alumni'): ?>
                                                            <span class="badge bg-secondary">Alumni</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-primary">Member</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($c['is_used']): ?>
                                                            <span class="badge bg-success">
                                                                <i class="bi bi-check-circle me-1"></i>Terpakai
                                                            </span>
                                                            <br><small class="text-muted"><?= date('d/m/Y H:i', strtotime($c['used_at'])) ?></small>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Belum Digunakan</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if ($c['user_type'] === 'delegasi' && !$c['is_used']): ?>
                                                            <a href="/admin/voting/delete-code?id=<?= $c['id'] ?>"
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Hapus kode ini?')">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">
                                                    Belum ada kode akses yang terdaftar.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member/Alumni -->
                <div class="tab-pane fade" id="tab-member">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kode Akses</th>
                                            <th>Nama</th>
                                            <th>NIM</th>
                                            <th>Tipe</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($memberCodes)): ?>
                                            <?php foreach ($memberCodes as $c): ?>
                                                <tr>
                                                    <td>
                                                        <code class="bg-light p-2 rounded"><?= htmlspecialchars($c['code']) ?></code>
                                                        <button class="btn btn-sm btn-link" onclick="copyCode('<?= $c['code'] ?>')">
                                                            <i class="bi bi-clipboard"></i>
                                                        </button>
                                                    </td>
                                                    <td class="fw-bold"><?= htmlspecialchars($c['voter_name']) ?></td>
                                                    <td><?= htmlspecialchars($c['voter_identifier']) ?></td>
                                                    <td>
                                                        <span class="badge bg-<?= $c['user_type'] === 'alumni' ? 'secondary' : 'primary' ?>">
                                                            <?= ucfirst($c['user_type']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($c['is_used']): ?>
                                                            <span class="badge bg-success">Terpakai</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Belum</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted">
                                                    Belum ada kode untuk member/alumni.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delegasi -->
                <div class="tab-pane fade" id="tab-delegasi">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Delegasi dapat mendaftar sendiri melalui halaman <strong>/delegate/login</strong>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kode Akses</th>
                                            <th>Nama</th>
                                            <th>NIM/Identitas</th>
                                            <th>Asal Instansi</th>
                                            <th>Terdaftar</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($delegateCodes)): ?>
                                            <?php foreach ($delegateCodes as $c):
                                                $metadata = !empty($c['voter_metadata']) ? json_decode($c['voter_metadata'], true) : null;
                                                $origin = $metadata['origin'] ?? '-';
                                                $registeredAt = $metadata['registered_at'] ?? null;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <code class="bg-warning bg-opacity-25 p-2 rounded"><?= htmlspecialchars($c['code']) ?></code>
                                                        <button class="btn btn-sm btn-link" onclick="copyCode('<?= $c['code'] ?>')">
                                                            <i class="bi bi-clipboard"></i>
                                                        </button>
                                                    </td>
                                                    <td class="fw-bold"><?= htmlspecialchars($c['voter_name']) ?></td>
                                                    <td><?= htmlspecialchars($c['voter_identifier'] ?? '-') ?></td>
                                                    <td>
                                                        <span class="badge bg-info"><?= htmlspecialchars($origin) ?></span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?= $registeredAt ? date('d/m/Y H:i', strtotime($registeredAt)) : '-' ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <?php if ($c['is_used']): ?>
                                                            <span class="badge bg-success">
                                                                <i class="bi bi-check-circle me-1"></i>Sudah Voting
                                                            </span>
                                                            <br><small class="text-muted"><?= date('d/m/Y H:i', strtotime($c['used_at'])) ?></small>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning">Belum Voting</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if (!$c['is_used']): ?>
                                                            <a href="/admin/voting/delete-code?id=<?= $c['id'] ?>"
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Hapus delegasi ini?')">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">
                                                    Belum ada delegasi yang terdaftar.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Delegasi Manual -->
    <div class="modal fade" id="delegateModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Generate Kode Delegasi Manual</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="/admin/voting/generate-delegate-code" method="POST">
                    <input type="hidden" name="election_id" value="<?= $election['id'] ?>">
                    <div class="modal-body">
                        <div class="alert alert-info small">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Catatan:</strong> Delegasi juga bisa mendaftar sendiri melalui halaman <code>/delegate/login</code>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Delegasi <span class="text-danger">*</span></label>
                            <input type="text" name="delegate_name" class="form-control" placeholder="Contoh: Ahmad Rizki" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIM/Identitas</label>
                            <input type="text" name="delegate_identifier" class="form-control" placeholder="Contoh: 2141720001">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Asal Instansi <span class="text-danger">*</span></label>
                            <input type="text" name="delegate_origin" class="form-control" placeholder="Contoh: HMTI Unibraw" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Generate Kode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/dashboard.js"></script>
    <script>
        function copyCode(code) {
            navigator.clipboard.writeText(code).then(() => {
                alert('Kode ' + code + ' berhasil disalin!');
            });
        }

        function exportCodes() {
            window.location.href = '/admin/voting/export-codes?id=<?= $election['id'] ?>';
        }
    </script>
</body>

</html>