<?php
$displayCodes = $filteredCodes ?? $codes ?? [];
?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold m-0">
                <i class="bi bi-table me-2"></i>
                Daftar Kode Akses (<?= count($displayCodes) ?>)
            </h6>
            <button class="btn btn-sm btn-success" onclick="exportCodes()">
                <i class="bi bi-file-earmark-excel me-1"></i> Export CSV
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Kode Akses</th>
                        <th>Nama Pemilih</th>
                        <th>Identitas</th>
                        <th>Tipe</th>
                        <th width="100" class="text-center">Status</th>
                        <th width="150">Digunakan Pada</th>
                        <th width="100" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($displayCodes)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                Belum ada kode yang di-generate.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($displayCodes as $index => $code): ?>
                            <tr class="<?= $code['is_used'] ? 'table-light' : '' ?>">
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <code class="bg-light px-2 py-1 rounded fw-bold">
                                        <?= htmlspecialchars($code['code']) ?>
                                    </code>
                                </td>
                                <td class="fw-bold"><?= htmlspecialchars($code['voter_name']) ?></td>
                                <td>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($code['voter_identifier'] ?? '-') ?>
                                    </small>
                                </td>
                                <td>
                                    <?php if ($code['user_type'] === 'delegasi'): ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-person-badge me-1"></i>Delegasi
                                        </span>
                                    <?php elseif ($code['user_type'] === 'alumni'): ?>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-mortarboard me-1"></i>Alumni
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">
                                            <i class="bi bi-people me-1"></i>Member
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($code['is_used']): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Terpakai
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-hourglass me-1"></i>Belum
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($code['is_used'] && $code['used_at']): ?>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($code['used_at'])) ?>
                                        </small>
                                    <?php else: ?>
                                        <small class="text-muted">-</small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light border" 
                                            onclick="copyCode('<?= htmlspecialchars($code['code']) ?>')"
                                            title="Salin Kode">
                                        <i class="bi bi-clipboard text-primary"></i>
                                    </button>
                                    
                                    <?php if ($code['user_type'] === 'delegasi' && !$code['is_used']): ?>
                                        <a href="/admin/voting/delete-code?id=<?= $code['id'] ?>" 
                                           class="btn btn-sm btn-light border"
                                           onclick="return confirm('Hapus kode ini?')"
                                           title="Hapus">
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>