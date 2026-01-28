<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$cart = $_SESSION['cart'] ?? [];

$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['qty'];
}

$adminFee = $subtotal * 0.05; // 5% biaya admin
$total = $subtotal + $adminFee;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - EEPROM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .cart-header {
            background: linear-gradient(135deg, #1A237E 0%, #3F51B5 100%);
            padding: 80px 0 60px;
            color: white;
            border-radius: 0 0 50px 50px;
        }

        .cart-card {
            background: white;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 30px;
        }

        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 25px 0;
            transition: all 0.3s;
        }

        .cart-item:hover {
            background: #f8f9fa;
            padding-left: 10px;
            border-radius: 15px;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 15px;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qty-btn {
            width: 35px;
            height: 35px;
            border: 2px solid #1A237E;
            background: white;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .qty-btn:hover {
            background: #1A237E;
            color: white;
        }

        .qty-display {
            width: 50px;
            text-align: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .remove-btn {
            color: #dc3545;
            cursor: pointer;
            transition: all 0.3s;
        }

        .remove-btn:hover {
            color: #c82333;
            transform: scale(1.2);
        }

        .summary-card {
            background: linear-gradient(135deg, #1A237E 0%, #3F51B5 100%);
            color: white;
            border-radius: 25px;
            padding: 30px;
            position: sticky;
            top: 20px;
        }

        .checkout-btn {
            background: linear-gradient(135deg, #FF5722 0%, #FF7043 100%);
            border: none;
            padding: 15px;
            font-weight: bold;
            border-radius: 15px;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 87, 34, 0.4);
        }

        .admin-fee-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../../Views/layouts/navbar-public.php'; ?>

    <div class="cart-header text-center">
        <div class="container">
            <h1 class="fw-bold display-5"><i class="bi bi-cart3 me-3"></i>Keranjang Belanja</h1>
            <p class="lead opacity-75">Periksa pesanan Anda sebelum checkout</p>
        </div>
    </div>

    <main class="container my-5">
        <?php if (empty($cart)): ?>
            <div class="cart-card text-center py-5">
                <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
                <h3 class="mt-4 text-muted">Keranjang Anda Kosong</h3>
                <p class="text-muted">Yuk, mulai berbelanja robot impianmu!</p>
                <a href="/product" class="btn btn-primary btn-lg rounded-pill mt-3 px-5">
                    <i class="bi bi-shop me-2"></i>Mulai Belanja
                </a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="cart-card">
                        <h4 class="fw-bold mb-4"><i class="bi bi-bag-check me-2 text-primary"></i>Produk Anda (<?= count($cart) ?> item)</h4>

                        <?php foreach ($cart as $id => $item): ?>
                            <div class="cart-item" data-id="<?= $id ?>">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="item-img">
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="fw-bold mb-1"><?= htmlspecialchars($item['name']) ?></h5>
                                        <p class="text-muted mb-0 small">Rp <?= number_format($item['price'], 0, ',', '.') ?> / item</p>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="qty-control">
                                            <button class="qty-btn" onclick="updateQty(<?= $id ?>, -1)">-</button>
                                            <span class="qty-display" id="qty-<?= $id ?>"><?= $item['qty'] ?></span>
                                            <button class="qty-btn" onclick="updateQty(<?= $id ?>, 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="fw-bold text-primary mb-0" id="subtotal-<?= $id ?>">
                                            Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?>
                                        </p>
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <i class="bi bi-trash remove-btn fs-4" onclick="removeItem(<?= $id ?>)"></i>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <h4 class="fw-bold mb-4"><i class="bi bi-receipt me-2"></i>Ringkasan Belanja</h4>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal (<?= array_sum(array_column($cart, 'qty')) ?> item)</span>
                            <span class="fw-bold" id="summarySubtotal">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-white border-opacity-25">
                            <span>Biaya Admin (5%)</span>
                            <span class="fw-bold" id="summaryAdminFee">Rp <?= number_format($adminFee, 0, ',', '.') ?></span>
                        </div>

                        <div class="admin-fee-info mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            <small>Biaya admin 5% sudah termasuk biaya operasional dan penanganan pesanan</small>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5 fw-bold">Total</span>
                            <span class="fs-4 fw-bold" id="summaryTotal">Rp <?= number_format($total, 0, ',', '.') ?></span>
                        </div>

                        <a href="/products/checkout" class="btn checkout-btn w-100 text-white">
                            <i class="bi bi-credit-card me-2"></i>Lanjut ke Pembayaran
                        </a>

                        <a href="/product" class="btn btn-outline-light w-100 mt-3 rounded-pill">
                            <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const cartData = <?= json_encode($cart) ?>;

        function updateQty(id, change) {
            const qtyEl = document.getElementById(`qty-${id}`);
            let newQty = parseInt(qtyEl.textContent) + change;

            if (newQty < 1) return;

            const formData = new FormData();
            formData.append('id', id);
            formData.append('qty', newQty);

            fetch('/products/update-cart', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Update display
                        qtyEl.textContent = newQty;

                        // Update subtotal
                        const price = cartData[id].price;
                        const subtotal = price * newQty;
                        document.getElementById(`subtotal-${id}`).textContent =
                            'Rp ' + subtotal.toLocaleString('id-ID');

                        // Update cart data
                        cartData[id].qty = newQty;

                        // Recalculate total
                        updateSummary();
                    }
                });
        }

        function removeItem(id) {
            if (!confirm('Yakin ingin menghapus produk ini?')) return;

            const formData = new FormData();
            formData.append('id', id);

            fetch('/products/remove-from-cart', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`[data-id="${id}"]`).remove();
                        delete cartData[id];
                        updateSummary();

                        // Reload if cart empty
                        if (Object.keys(cartData).length === 0) {
                            location.reload();
                        }
                    }
                });
        }

        function updateSummary() {
            let subtotal = 0;
            let totalQty = 0;

            for (let id in cartData) {
                subtotal += cartData[id].price * cartData[id].qty;
                totalQty += cartData[id].qty;
            }

            const adminFee = subtotal * 0.05; // 5% biaya admin
            const total = subtotal + adminFee;

            document.getElementById('summarySubtotal').textContent =
                'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('summaryAdminFee').textContent =
                'Rp ' + adminFee.toLocaleString('id-ID');
            document.getElementById('summaryTotal').textContent =
                'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
</body>

</html>