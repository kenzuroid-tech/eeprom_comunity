<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?> - EEPROM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }

        .detail-header {
            background: linear-gradient(135deg, #1A237E 0%, #3F51B5 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="detail-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/products/orders" class="text-white-50">Riwayat</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Detail Pesanan</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">Order #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></h2>
                <span class="badge bg-white text-primary px-3 py-2 rounded-pill">
                    <?= ucfirst($order['status']) ?>
                </span>
            </div>
        </div>
    </div>

    <main class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card p-4">
                    <h5 class="fw-bold mb-4"><i class="bi bi-box-seam me-2 text-primary"></i>Item Pesanan</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-3">
                                                    <h6 class="mb-0 fw-bold"><?= htmlspecialchars($item['product_name']) ?></h6>
                                                    <small class="text-muted">ID: <?= $item['product_id'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                        <td class="text-center"><?= $item['quantity'] ?></td>
                                        <td class="text-end fw-bold">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold fs-5">Total Pembayaran</td>
                                    <td class="text-end fw-bold fs-5 text-primary">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-4 mb-4">
                    <h5 class="fw-bold mb-3 small text-uppercase text-muted">Informasi Pengiriman</h5>
                    <p class="mb-1 fw-bold"><?= htmlspecialchars($order['customer_name']) ?></p>
                    <p class="mb-1 text-muted"><?= htmlspecialchars($order['phone']) ?></p>
                    <p class="mb-0"><?= nl2br(htmlspecialchars($order['address'])) ?></p>
                </div>

                <div class="card p-4">
                    <h5 class="fw-bold mb-3 small text-uppercase text-muted">Metode Pembayaran</h5>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-wallet2 fs-4 me-3 text-primary"></i>
                        <div>
                            <p class="mb-0 fw-bold">
                                <?= ($order['payment_method'] == 'bank_transfer') ? 'Transfer Bank' : strtoupper($order['payment_method']) ?>
                            </p>
                            <small class="text-muted">Status: <?= ($order['status'] == 'pending') ? 'Belum Dibayar' : 'Sudah Dikonfirmasi' ?></small>
                        </div>
                    </div>
                    <hr>
                    <a href="https://wa.me/628123456789?text=Halo%20Admin,%20saya%20ingin%20konfirmasi%20pesanan%20%23<?= $order['id'] ?>"
                        class="btn btn-success w-100 rounded-pill">
                        <i class="bi bi-whatsapp me-2"></i>Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>