<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - EEPROM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .orders-header {
            background: linear-gradient(135deg, #1A237E 0%, #3F51B5 100%);
            padding: 80px 0 60px;
            color: white;
            border-radius: 0 0 50px 50px;
        }

        .order-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
            color: #E65100;
        }

        .status-processing {
            background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
            color: #0D47A1;
        }

        .status-shipped {
            background: linear-gradient(135deg, #F3E5F5 0%, #E1BEE7 100%);
            color: #4A148C;
        }

        .status-delivered {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            color: #1B5E20;
        }

        .status-cancelled {
            background: linear-gradient(135deg, #FFEBEE 0%, #FFCDD2 100%);
            color: #B71C1C;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e0e0e0;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 15px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 5px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #1A237E;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #1A237E;
        }

        .success-alert {
            background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.3);
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../../Views/layouts/navbar-public.php'; ?>

    <div class="orders-header text-center">
        <div class="container">
            <h1 class="fw-bold display-5"><i class="bi bi-clock-history me-3"></i>Riwayat Pesanan</h1>
            <p class="lead opacity-75">Pantau status pesanan Anda</p>
        </div>
    </div>

    <main class="container my-5">
        <?php if (isset($_GET['success'])): ?>
            <div class="success-alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-1 me-3"></i>
                    <div>
                        <h4 class="mb-1">Pesanan Berhasil Dibuat!</h4>
                        <p class="mb-0">Tim EEPROM akan segera menghubungi Anda via WhatsApp untuk konfirmasi.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order):
                // Status mapping
                $statusMap = [
                    'pending' => ['label' => 'Menunggu Pembayaran', 'class' => 'status-pending', 'icon' => 'hourglass-split'],
                    'processing' => ['label' => 'Diproses', 'class' => 'status-processing', 'icon' => 'gear-fill'],
                    'shipped' => ['label' => 'Dikirim', 'class' => 'status-shipped', 'icon' => 'truck'],
                    'delivered' => ['label' => 'Selesai', 'class' => 'status-delivered', 'icon' => 'check-circle-fill'],
                    'cancelled' => ['label' => 'Dibatalkan', 'class' => 'status-cancelled', 'icon' => 'x-circle-fill']
                ];

                $status = $statusMap[$order['status']] ?? $statusMap['pending'];

                // Estimasi waktu
                $createdDate = new DateTime($order['created_at']);
                $estimatedDate = clone $createdDate;
                $estimatedDate->modify('+7 days');
            ?>
                <div class="order-card">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-8">
                            <h5 class="fw-bold mb-2">
                                <i class="bi bi-receipt text-primary me-2"></i>
                                Order #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?>
                            </h5>
                            <p class="text-muted mb-0 small">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?= date('d F Y, H:i', strtotime($order['created_at'])) ?> WIB
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <span class="status-badge <?= $status['class'] ?>">
                                <i class="bi bi-<?= $status['icon'] ?> me-1"></i>
                                <?= $status['label'] ?>
                            </span>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <h6 class="fw-bold mb-3"><i class="bi bi-person-circle text-primary me-2"></i>Informasi Pembeli</h6>
                                <p class="mb-2"><strong>Nama:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                                <p class="mb-2"><strong>No. WhatsApp:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                                <p class="mb-2"><strong>Alamat:</strong> <?= htmlspecialchars($order['address']) ?></p>
                                <p class="mb-0"><strong>Metode Pembayaran:</strong>
                                    <?php
                                    $paymentLabels = [
                                        'bank_transfer' => 'Transfer Bank',
                                        'qris' => 'QRIS',
                                        'cod' => 'Bayar di Tempat'
                                    ];
                                    echo $paymentLabels[$order['payment_method']] ?? $order['payment_method'];
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <h6 class="fw-bold mb-3"><i class="bi bi-clock-history text-primary me-2"></i>Timeline Pesanan</h6>
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <small class="text-muted d-block">Pesanan dibuat</small>
                                        <small class="fw-bold"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></small>
                                    </div>

                                    <?php if ($order['status'] !== 'pending' && $order['status'] !== 'cancelled'): ?>
                                        <div class="timeline-item">
                                            <small class="text-muted d-block">Pembayaran dikonfirmasi</small>
                                            <small class="fw-bold">-</small>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($order['status'] === 'shipped' || $order['status'] === 'delivered'): ?>
                                        <div class="timeline-item">
                                            <small class="text-muted d-block">Pesanan dikirim</small>
                                            <small class="fw-bold">-</small>
                                        </div>
                                    <?php endif; ?>

                                    <div class="timeline-item">
                                        <small class="text-muted d-block">Estimasi tiba</small>
                                        <small class="fw-bold"><?= $estimatedDate->format('d M Y') ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-top mt-3 pt-3 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">Total Pembayaran:</span>
                            <span class="fs-4 fw-bold text-primary ms-2">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></span>
                        </div>
                        <a href="/products/order-detail?id=<?= $order['id'] ?>" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="bi bi-eye me-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="order-card text-center py-5">
                <i class="bi bi-inbox display-1 text-muted opacity-25"></i>
                <h3 class="mt-4 text-muted">Belum Ada Pesanan</h3>
                <p class="text-muted">Anda belum pernah melakukan pemesanan</p>
                <a href="/product" class="btn btn-primary btn-lg rounded-pill mt-3 px-5">
                    <i class="bi bi-shop me-2"></i>Mulai Belanja
                </a>
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>