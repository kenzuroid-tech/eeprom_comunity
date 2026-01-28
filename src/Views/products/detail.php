<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['qty'];
    }
}

$photos = json_decode($product['photos'] ?? '[]', true);
$video = $product['video_url'] ?? null;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - EEPROM Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/product/index.css">
    <style>
        .detail-header {
            background: linear-gradient(135deg, #1A237E 0%, #3F51B5 100%);
            padding: 120px 0 80px;
            color: white;
            border-radius: 0 0 50px 50px;
        }

        .main-img-display {
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 450px;
        }

        .main-img-display img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: 0.5s;
        }

        .thumb-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 15px;
            cursor: pointer;
            transition: 0.3s;
            border: 2px solid #eee;
        }

        .thumb-img:hover,
        .thumb-img.active {
            border-color: #FF5722;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(255, 87, 34, 0.2);
        }

        .spec-card {
            background: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .price-tag {
            font-size: 2rem;
            font-weight: 800;
            color: #1A237E;
        }

        .video-btn-thumb {
            background: #000;
            position: relative;
        }

        .video-btn-thumb::after {
            content: "\f4ad";
            font-family: "bootstrap-icons";
            position: absolute;
            color: white;
            font-size: 1.5rem;
        }

        /* Quantity Selector */
        .qty-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #1A237E;
            background: white;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #1A237E;
            cursor: pointer;
            transition: all 0.3s;
        }

        .qty-btn:hover {
            background: #1A237E;
            color: white;
        }

        .qty-input {
            width: 80px;
            height: 40px;
            text-align: center;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .total-price-display {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        /* Floating Cart */
        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        .cart-btn {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF5722 0%, #FF7043 100%);
            border: none;
            box-shadow: 0 8px 25px rgba(255, 87, 34, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            transition: all 0.3s;
            position: relative;
        }

        .cart-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(255, 87, 34, 0.5);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #1A237E;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            border: 2px solid white;
        }

        .pulse {
            animation: pulse 0.5s;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }
    </style>
</head>

<body class="bg-light">
    <?php include __DIR__ . '/../../Views/layouts/navbar-public.php'; ?>

    <div class="detail-header text-center">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-2">
                    <li class="breadcrumb-item"><a href="/product" class="text-white-50 text-decoration-none">Marketplace</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Detail Robot</li>
                </ol>
            </nav>
            <h1 class="fw-bold display-5"><?= htmlspecialchars($product['name']) ?></h1>
        </div>
    </div>

    <main class="container mb-5" style="margin-top: -50px;">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="main-img-display mb-3 p-3">
                    <img id="activeImg" src="<?= !empty($photos) ? $photos[0] : '/assets/images/default_robot.png' ?>" alt="Main Product Image">
                </div>
                <div class="d-flex gap-2 overflow-auto pb-2 justify-content-center">
                    <?php foreach ($photos as $index => $img): ?>
                        <img src="<?= $img ?>" class="thumb-img <?= $index === 0 ? 'active' : '' ?>" onclick="changeImg(this, '<?= $img ?>')">
                    <?php endforeach; ?>

                    <?php if ($video): ?>
                        <div class="thumb-img video-btn-thumb d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#vModal">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="spec-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-4 py-2 fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                            <?= htmlspecialchars($product['category']) ?>
                        </span>
                    </div>

                    <div class="price-tag mb-4">
                        <small class="fs-6 fw-normal text-muted">Harga Satuan:</small><br>
                        Rp <span id="unitPrice"><?= number_format($product['price'], 0, ',', '.') ?></span>
                    </div>

                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">Deskripsi Produk</h5>
                    <div class="text-muted mb-4" style="line-height: 1.8; text-align: justify; font-size: 0.95rem;">
                        <?= nl2br(htmlspecialchars($product['description'])) ?>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="qty-selector">
                        <label class="fw-bold text-dark">Jumlah:</label>
                        <button type="button" class="qty-btn" onclick="decreaseQty()">-</button>
                        <input type="number" id="qtyInput" class="qty-input" value="1" min="1" onchange="updateTotal()">
                        <button type="button" class="qty-btn" onclick="increaseQty()">+</button>
                    </div>

                    <!-- Total Price Display -->
                    <div class="total-price-display">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">Total Harga:</span>
                            <span class="price-tag" style="font-size: 1.8rem;">Rp <span id="totalPrice"><?= number_format($product['price'], 0, ',', '.') ?></span></span>
                        </div>
                    </div>

                    <form id="cartForm" action="/products/add-to-cart" method="POST">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                        <input type="hidden" name="price" value="<?= $product['price'] ?>">
                        <input type="hidden" name="image" value="<?= !empty($photos) ? $photos[0] : '' ?>">
                        <input type="hidden" name="qty" id="qtyHidden" value="1">
                        <input type="hidden" name="redirect" value="/products/detail?id=<?= $product['id'] ?>">

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold py-3 shadow-lg border-0" style="background: linear-gradient(135deg, #FF5722 0%, #FF7043 100%);">
                                <i class="bi bi-cart-plus-fill me-2"></i>Masukkan ke Keranjang
                            </button>
                            <a href="/product" class="btn btn-outline-secondary btn-lg rounded-pill fw-bold py-3 border-2">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Katalog
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Floating Cart Button -->
    <div class="floating-cart">
        <a href="/products/cart" class="cart-btn">
            <i class="bi bi-cart3"></i>
            <?php if ($cartCount > 0): ?>
                <span class="cart-badge" id="cartBadge"><?= $cartCount ?></span>
            <?php endif; ?>
        </a>
    </div>

    <?php if ($video): ?>
        <div class="modal fade" id="vModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-dark border-0 overflow-hidden">
                    <div class="modal-header border-0 pb-0">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <video width="100%" controls class="d-block">
                            <source src="<?= $video ?>" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        const unitPrice = <?= $product['price'] ?>;

        function changeImg(el, src) {
            document.getElementById('activeImg').src = src;
            document.querySelectorAll('.thumb-img').forEach(img => img.classList.remove('active'));
            el.classList.add('active');
        }

        function increaseQty() {
            const input = document.getElementById('qtyInput');
            input.value = parseInt(input.value) + 1;
            updateTotal();
        }

        function decreaseQty() {
            const input = document.getElementById('qtyInput');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateTotal();
            }
        }

        function updateTotal() {
            const qty = parseInt(document.getElementById('qtyInput').value) || 1;
            const total = unitPrice * qty;

            document.getElementById('totalPrice').textContent = total.toLocaleString('id-ID');
            document.getElementById('qtyHidden').value = qty;
        }

        // Form submission dengan animasi
        document.getElementById('cartForm').addEventListener('submit', function(e) {
            document.querySelector('.cart-btn').classList.add('pulse');
            setTimeout(() => {
                document.querySelector('.cart-btn').classList.remove('pulse');
            }, 500);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>