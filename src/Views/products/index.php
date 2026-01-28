<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['qty'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/product/index.css">
    <style>
        /* Floating Cart Button */
        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .cart-btn,
        .orders-btn {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            border: none;
            box-shadow: 0 8px 25px rgba(255, 87, 34, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            transition: all 0.3s;
            position: relative;
            text-decoration: none;
        }

        .cart-btn {
            background: linear-gradient(135deg, #FF5722 0%, #FF7043 100%);
        }

        .orders-btn {
            background: linear-gradient(135deg, #1A237E 0%, #3949AB 100%);
            box-shadow: 0 8px 25px rgba(26, 35, 126, 0.4);
        }

        .cart-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(255, 87, 34, 0.5);
            color: white;
        }

        .orders-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(26, 35, 126, 0.5);
            color: white;
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

        .product-card {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .btn-add-cart {
            background: linear-gradient(135deg, #FF5722 0%, #FF7043 100%);
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-add-cart:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255, 87, 34, 0.3);
            color: white;
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

        /* Tooltip for floating buttons */
        .floating-cart a[title]:hover::before {
            content: attr(title);
            position: absolute;
            right: 75px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 12px;
            border-radius: 8px;
            white-space: nowrap;
            font-size: 0.85rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../../Views/layouts/navbar-public.php'; ?>

    <header class="page-header">
        <div class="container text-center">
            <h1 class="section-heading-white">Robot Marketplace</h1>
            <div class="header-divider mx-auto"></div>
            <p class="lead opacity-75">Inovasi Robotika Terbaik dari EEPROM POLINEMA</p>
        </div>
    </header>

    <main class="container my-5">
        <div class="filter-container d-flex justify-content-center gap-2 mb-5 overflow-auto pb-2">
            <button class="btn-filter active">Semua</button>
            <button class="btn-filter">Line Follower</button>
            <button class="btn-filter">Rescue Robot</button>
            <button class="btn-filter">Transporter</button>
        </div>

        <div class="row g-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $p):
                    $photos = json_decode($p['photos'] ?? '[]', true);
                    $productId = $p['id'];
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="product-card h-100 shadow-sm border-0 d-flex flex-column">
                            <div class="product-badge"><?= htmlspecialchars($p['category']) ?></div>

                            <div id="carousel<?= $productId ?>" class="carousel slide product-img-container" data-bs-ride="false">
                                <div class="carousel-inner h-100">
                                    <?php if (!empty($photos)): ?>
                                        <?php foreach ($photos as $index => $img): ?>
                                            <div class="carousel-item h-100 <?= $index === 0 ? 'active' : '' ?>">
                                                <img src="<?= htmlspecialchars($img) ?>" class="d-block w-100 h-100" style="object-fit: cover;" alt="Robot Image">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="carousel-item active h-100">
                                            <img src="https://placehold.co/600x400/1A237E/FFF?text=No+Image" class="d-block w-100 h-100" style="object-fit: cover;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if (count($photos) > 1): ?>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $productId ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $productId ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                <?php endif; ?>
                            </div>

                            <div class="product-info p-4 d-flex flex-column flex-grow-1">
                                <h4 class="product-title fw-bold"><?= htmlspecialchars($p['name']) ?></h4>
                                <p class="product-desc text-muted small mb-3">
                                    <?= nl2br(htmlspecialchars(substr($p['description'], 0, 100))) ?><?= strlen($p['description']) > 100 ? '...' : '' ?>
                                </p>

                                <div class="d-flex justify-content-between align-items-center mb-3 pt-3 border-top">
                                    <div class="price-wrapper">
                                        <span class="detail-label text-uppercase x-small fw-bold text-muted d-block" style="font-size: 0.7rem;">Harga</span>
                                        <span class="product-price fw-bold text-primary fs-5">Rp <?= number_format($p['price'], 0, ',', '.') ?></span>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 mt-auto">
                                    <a href="/products/detail?id=<?= $productId ?>" class="btn btn-outline-primary rounded-pill">
                                        <i class="bi bi-info-circle me-1"></i> Lihat Detail
                                    </a>
                                    <button class="btn btn-add-cart rounded-pill add-to-cart-btn"
                                        data-id="<?= $productId ?>"
                                        data-name="<?= htmlspecialchars($p['name']) ?>"
                                        data-price="<?= $p['price'] ?>"
                                        data-image="<?= !empty($photos) ? htmlspecialchars($photos[0]) : '' ?>">
                                        <i class="bi bi-cart-plus me-1"></i> Masukkan Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-robot display-1 text-muted opacity-25"></i>
                    <p class="mt-3 text-muted">Belum ada produk yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Floating Action Buttons -->
    <div class="floating-cart">
        <a href="/products/orders" class="orders-btn" title="Pesanan Saya">
            <i class="bi bi-receipt"></i>
        </a>
        <a href="/products/cart" class="cart-btn" title="Keranjang">
            <i class="bi bi-cart3"></i>
            <?php if ($cartCount > 0): ?>
                <span class="cart-badge" id="cartBadge"><?= $cartCount ?></span>
            <?php endif; ?>
        </a>
    </div>

    <?php include __DIR__ . '/../../Views/layouts/footer-public.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add to cart functionality
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const formData = new FormData();
                formData.append('id', this.dataset.id);
                formData.append('name', this.dataset.name);
                formData.append('price', this.dataset.price);
                formData.append('image', this.dataset.image);
                formData.append('ajax', '1');

                fetch('/products/add-to-cart', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Update badge
                            const badge = document.getElementById('cartBadge');
                            if (badge) {
                                badge.textContent = data.cart_count;
                            } else {
                                const cartBtn = document.querySelector('.cart-btn');
                                cartBtn.innerHTML += `<span class="cart-badge" id="cartBadge">${data.cart_count}</span>`;
                            }

                            // Animate cart button
                            document.querySelector('.cart-btn').classList.add('pulse');
                            setTimeout(() => {
                                document.querySelector('.cart-btn').classList.remove('pulse');
                            }, 500);

                            // Show success message
                            alert('Produk berhasil ditambahkan ke keranjang!');
                        }
                    });
            });
        });
    </script>
</body>

</html>