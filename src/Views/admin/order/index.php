<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pesanan - EEPROM ADMIN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <style>
        .status-badge {
            font-size: 0.75rem;
            padding: 5px 12px;
            font-weight: 600;
        }

        .bg-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .bg-processing {
            background-color: #e0f2fe;
            color: #075985;
        }

        .bg-shipped {
            background-color: #f3e8ff;
            color: #6b21a8;
        }

        .bg-delivered {
            background-color: #dcfce7;
            color: #166534;
        }

        .bg-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <main id="mainContentWrapper" class="admin-main-content">
            <nav class="navbar-top-admin shadow-sm mb-4 px-4 py-3 bg-white rounded-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-primary border-0 me-3 d-lg-none" onclick="toggleSidebar()">
                        <i class="bi bi-list fs-3"></i>
                    </button>
                    <div>
                        <h4 class="m-0 fw-bold text-dark">Manajemen Pesanan</h4>
                        <p class="m-0 small text-muted d-none d-md-block">Pantau dan proses pesanan masuk dari pelanggan.</p>
                    </div>
                </div>
            </nav>

            <div class="admin-widget-card shadow-sm p-4 bg-white rounded-4">
                <div class="table-responsive rounded-4 border">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3 py-3">ID Order</th>
                                <th>Pelanggan</th>
                                <th>Metode</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $o): ?>
                                    <tr>
                                        <td class="ps-3 fw-bold text-primary">#<?= str_pad($o['id'], 6, '0', STR_PAD_LEFT) ?></td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($o['customer_name']) ?></div>
                                            <small class="text-muted"><?= $o['phone'] ?></small>
                                        </td>
                                        <td>
                                            <span class="text-uppercase small fw-medium"><?= str_replace('_', ' ', $o['payment_method']) ?></span>
                                        </td>
                                        <td class="fw-bold">Rp <?= number_format($o['total_price'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge rounded-pill status-badge bg-<?= $o['status'] ?>">
                                                <?= strtoupper($o['status']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" onclick="viewDetail(<?= $o['id'] ?>)">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 opacity-25"></i>
                                        <p class="mt-2 fw-bold">Belum ada pesanan masuk.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Detail Pesanan <span id="modalOrderId" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="small text-muted d-block">Pelanggan</label>
                            <p class="fw-bold mb-3" id="detailCustomer"></p>
                            <label class="small text-muted d-block">Alamat Pengiriman</label>
                            <p class="small" id="detailAddress"></p>
                        </div>
                        <div class="col-md-6 border-start">
                            <form action="/admin/orders/update-status" method="POST">
                                <input type="hidden" name="id" id="statusOrderId">
                                <label class="small fw-bold mb-2">Update Status Pesanan</label>
                                <div class="input-group">
                                    <select name="status" id="statusSelect" class="form-select rounded-start-3">
                                        <option value="pending">PENDING</option>
                                        <option value="processing">PROCESSING</option>
                                        <option value="shipped">SHIPPED</option>
                                        <option value="delivered">DELIVERED</option>
                                        <option value="cancelled">CANCELLED</option>
                                    </select>
                                    <button class="btn btn-primary fw-bold px-3">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive border rounded-3">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3 py-2">Produk</th>
                                    <th>Qty</th>
                                    <th class="text-end pe-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="itemsTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));

        function viewDetail(id) {
            fetch('/admin/orders/detail?id=' + id)
                .then(res => res.json())
                .then(data => {
                    const order = data.order;
                    const items = data.items;

                    document.getElementById('modalOrderId').innerText = '#' + String(order.id).padStart(6, '0');
                    document.getElementById('statusOrderId').value = order.id;
                    document.getElementById('detailCustomer').innerText = order.customer_name + ' (' + order.phone + ')';
                    document.getElementById('detailAddress').innerText = order.address;
                    document.getElementById('statusSelect').value = order.status;

                    let itemsHtml = '';
                    items.forEach(item => {
                        itemsHtml += `
                            <tr>
                                <td class="ps-3 py-2 fw-medium">${item.product_name}</td>
                                <td>${item.quantity}</td>
                                <td class="text-end pe-3 fw-bold text-primary">Rp ${parseInt(item.subtotal).toLocaleString('id-ID')}</td>
                            </tr>
                        `;
                    });

                    // Add Total Row
                    itemsHtml += `
                        <tr class="table-light">
                            <td colspan="2" class="ps-3 fw-bold">TOTAL</td>
                            <td class="text-end pe-3 fw-bold fs-5 text-primary">Rp ${parseInt(order.total_price).toLocaleString('id-ID')}</td>
                        </tr>
                    `;

                    document.getElementById('itemsTableBody').innerHTML = itemsHtml;
                    orderModal.show();
                })
                .catch(err => alert("Gagal memuat detail: " + err));
        }
    </script>
</body>

</html>