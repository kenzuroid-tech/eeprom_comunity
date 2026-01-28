<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header('Location: /product');
    exit;
}

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
    <title>Checkout - EEPROM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .checkout-header {
            background: linear-gradient(135deg, #1A237E 0%, #3F51B5 100%);
            padding: 80px 0 60px;
            color: white;
            border-radius: 0 0 50px 50px;
        }

        .form-card {
            background: white;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            padding: 40px;
        }

        .payment-option {
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 15px;
        }

        .payment-option:hover {
            border-color: #1A237E;
            background: #f8f9fa;
        }

        .payment-option.active {
            border-color: #1A237E;
            background: linear-gradient(135deg, rgba(26, 35, 126, 0.05) 0%, rgba(63, 81, 181, 0.05) 100%);
        }

        .payment-option input[type="radio"] {
            width: 20px;
            height: 20px;
        }

        .payment-details {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-top: 15px;
            display: none;
        }

        .payment-details.active {
            display: block;
        }

        .qr-code {
            max-width: 250px;
            margin: 20px auto;
            display: block;
        }

        .upload-area {
            border: 2px dashed #1A237E;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            background: white;
            transition: all 0.3s;
            cursor: pointer;
        }

        .upload-area:hover {
            background: #f8f9fa;
            border-color: #3F51B5;
        }

        .upload-area.dragover {
            background: #e8eaf6;
            border-color: #3F51B5;
        }

        .preview-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            margin-top: 15px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #FF5722 0%, #FF7043 100%);
            border: none;
            padding: 15px;
            font-weight: bold;
            border-radius: 15px;
            color: white;
            width: 100%;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 87, 34, 0.4);
        }

        .submit-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .order-summary {
            background: linear-gradient(135deg, #1A237E 0%, #3F51B5 100%);
            color: white;
            border-radius: 25px;
            padding: 30px;
            position: sticky;
            top: 20px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #1A237E;
            box-shadow: 0 0 0 0.2rem rgba(26, 35, 126, 0.15);
        }

        .total-amount-highlight {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 12px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../../Views/layouts/navbar-public.php'; ?>

    <div class="checkout-header text-center">
        <div class="container">
            <h1 class="fw-bold display-5"><i class="bi bi-credit-card me-3"></i>Checkout</h1>
            <p class="lead opacity-75">Lengkapi data untuk menyelesaikan pesanan</p>
        </div>
    </div>

    <main class="container my-5">
        <form action="/products/checkout" method="POST" enctype="multipart/form-data" id="checkoutForm">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="form-card mb-4">
                        <h4 class="fw-bold mb-4"><i class="bi bi-person-circle me-2 text-primary"></i>Data Pembeli</h4>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control" rows="4" placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota" required></textarea>
                        </div>
                    </div>

                    <div class="form-card">
                        <h4 class="fw-bold mb-4"><i class="bi bi-wallet2 me-2 text-primary"></i>Metode Pembayaran</h4>

                        <!-- Transfer Bank -->
                        <div class="payment-option" onclick="selectPayment('bank')">
                            <div class="d-flex align-items-center">
                                <input type="radio" name="payment_method" value="bank_transfer" id="bank" class="me-3" required>
                                <div class="flex-grow-1">
                                    <label for="bank" class="fw-bold mb-0 d-block" style="cursor: pointer;">Transfer Bank</label>
                                    <small class="text-muted">BCA, BNI, Mandiri</small>
                                </div>
                                <i class="bi bi-bank2 fs-3 text-primary"></i>
                            </div>
                        </div>
                        <div class="payment-details" id="details-bank">
                            <h6 class="fw-bold mb-3">Rekening Tujuan:</h6>
                            <div class="alert alert-info mb-2">
                                <strong>BCA: 1234567890</strong><br>
                                a.n. EEPROM POLINEMA
                            </div>
                            <div class="alert alert-info mb-2">
                                <strong>BNI: 0987654321</strong><br>
                                a.n. EEPROM POLINEMA
                            </div>
                            <div class="alert alert-info mb-3">
                                <strong>Mandiri: 1122334455</strong><br>
                                a.n. EEPROM POLINEMA
                            </div>

                            <div class="total-amount-highlight text-center">
                                <small class="d-block text-muted mb-1">Total Yang Harus Dibayar:</small>
                                <h3 class="fw-bold mb-0 text-danger">Rp <?= number_format($total, 0, ',', '.') ?></h3>
                            </div>

                            <div class="mt-3">
                                <label class="form-label fw-bold">Upload Bukti Transfer <span class="text-danger">*</span></label>
                                <div class="upload-area" onclick="document.getElementById('bank_proof').click()">
                                    <i class="bi bi-cloud-upload fs-1 text-primary"></i>
                                    <p class="mb-0 mt-2 fw-bold">Klik untuk upload bukti transfer</p>
                                    <small class="text-muted">Format: JPG, PNG, PDF (Max 5MB)</small>
                                </div>
                                <input type="file" name="payment_proof" id="bank_proof" class="d-none" accept="image/*,.pdf" onchange="previewFile(this, 'bank_preview')">
                                <div id="bank_preview"></div>
                            </div>
                        </div>

                        <!-- QRIS -->
                        <div class="payment-option" onclick="selectPayment('qris')">
                            <div class="d-flex align-items-center">
                                <input type="radio" name="payment_method" value="qris" id="qris" class="me-3" required>
                                <div class="flex-grow-1">
                                    <label for="qris" class="fw-bold mb-0 d-block" style="cursor: pointer;">QRIS</label>
                                    <small class="text-muted">Semua aplikasi e-wallet</small>
                                </div>
                                <i class="bi bi-qr-code fs-3 text-primary"></i>
                            </div>
                        </div>
                        <div class="payment-details" id="details-qris">
                            <h6 class="fw-bold mb-3 text-center">Scan QR Code untuk Membayar:</h6>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=00020101021226670016COM.NOBUBANK.WWW01189360050300000898740214<?= $total ?>0303UMI51440014ID.CO.QRIS.WWW0215ID10200009876540303UMI5204481253033605802ID5913EEPROM%20POLINEMA6015MALANG6304"
                                alt="QR Code" class="qr-code border p-2 bg-white">

                            <div class="total-amount-highlight text-center">
                                <small class="d-block text-muted mb-1">Total Yang Harus Dibayar:</small>
                                <h3 class="fw-bold mb-0 text-danger">Rp <?= number_format($total, 0, ',', '.') ?></h3>
                            </div>

                            <div class="mt-3">
                                <label class="form-label fw-bold">Upload Bukti Pembayaran QRIS <span class="text-danger">*</span></label>
                                <div class="upload-area" onclick="document.getElementById('qris_proof').click()">
                                    <i class="bi bi-cloud-upload fs-1 text-primary"></i>
                                    <p class="mb-0 mt-2 fw-bold">Klik untuk upload screenshot bukti</p>
                                    <small class="text-muted">Format: JPG, PNG (Max 5MB)</small>
                                </div>
                                <input type="file" name="payment_proof" id="qris_proof" class="d-none" accept="image/*" onchange="previewFile(this, 'qris_preview')">
                                <div id="qris_preview"></div>
                            </div>
                        </div>

                        <!-- Cash on Delivery -->
                        <div class="payment-option" onclick="selectPayment('cod')">
                            <div class="d-flex align-items-center">
                                <input type="radio" name="payment_method" value="cod" id="cod" class="me-3" required>
                                <div class="flex-grow-1">
                                    <label for="cod" class="fw-bold mb-0 d-block" style="cursor: pointer;">Bayar di Tempat (COD)</label>
                                    <small class="text-muted">Bayar saat pengambilan barang</small>
                                </div>
                                <i class="bi bi-cash-coin fs-3 text-primary"></i>
                            </div>
                        </div>
                        <div class="payment-details" id="details-cod">
                            <h6 class="fw-bold mb-3">Lokasi Pengambilan:</h6>
                            <div class="alert alert-success">
                                <i class="bi bi-geo-alt-fill me-2"></i>
                                <strong>Lab EEPROM - Jurusan Teknik Elektro</strong><br>
                                Politeknik Negeri Malang<br>
                                Jl. Soekarno Hatta No.9, Malang, Jawa Timur 65141
                            </div>
                            <p class="small text-muted mb-0">
                                <i class="bi bi-clock me-1"></i>
                                <strong>Jam Operasional:</strong> Senin - Jumat, 08:00 - 16:00 WIB
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="order-summary">
                        <h4 class="fw-bold mb-4"><i class="bi bi-receipt me-2"></i>Ringkasan Pesanan</h4>

                        <?php foreach ($cart as $item): ?>
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-white border-opacity-25">
                                <span><?= htmlspecialchars($item['name']) ?> (x<?= $item['qty'] ?>)</span>
                                <span>Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?></span>
                            </div>
                        <?php endforeach; ?>

                        <div class="d-flex justify-content-between mb-3 mt-4">
                            <span class="fw-bold">Subtotal</span>
                            <span class="fw-bold">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>Biaya Admin (5%)</span>
                            <span>Rp <?= number_format($adminFee, 0, ',', '.') ?></span>
                        </div>

                        <div class="d-flex justify-content-between mb-4 pt-3 border-top border-white border-opacity-50">
                            <span class="fs-5 fw-bold">Total</span>
                            <span class="fs-4 fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></span>
                        </div>

                        <button type="submit" class="submit-btn" id="submitBtn">
                            <i class="bi bi-check-circle me-2"></i>Buat Pesanan Sekarang
                        </button>

                        <a href="/products/cart" class="btn btn-outline-light w-100 mt-3 rounded-pill">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedPayment = null;

        function selectPayment(method) {
            selectedPayment = method;

            // Remove all active classes
            document.querySelectorAll('.payment-option').forEach(el => {
                el.classList.remove('active');
            });
            document.querySelectorAll('.payment-details').forEach(el => {
                el.classList.remove('active');
            });

            // Remove required from all file inputs
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.removeAttribute('required');
            });

            // Add active to selected
            const option = document.querySelector(`.payment-option:has(#${method})`);
            option.classList.add('active');
            document.getElementById(`details-${method}`).classList.add('active');

            // Check the radio button
            document.getElementById(method).checked = true;

            // Add required to payment proof if bank or qris
            if (method === 'bank') {
                document.getElementById('bank_proof').setAttribute('required', 'required');
            } else if (method === 'qris') {
                document.getElementById('qris_proof').setAttribute('required', 'required');
            }
        }

        function previewFile(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];

            if (file) {
                // Check file size (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 5MB');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (file.type.includes('image')) {
                        preview.innerHTML = `
                            <div class="text-center mt-3">
                                <p class="text-success fw-bold mb-2"><i class="bi bi-check-circle me-2"></i>Bukti pembayaran berhasil diupload</p>
                                <img src="${e.target.result}" class="preview-image">
                                <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeFile('${input.id}', '${previewId}')">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </div>
                        `;
                    } else {
                        preview.innerHTML = `
                            <div class="alert alert-success mt-3">
                                <i class="bi bi-file-pdf me-2"></i>${file.name}
                                <button type="button" class="btn btn-sm btn-danger float-end" onclick="removeFile('${input.id}', '${previewId}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        function removeFile(inputId, previewId) {
            document.getElementById(inputId).value = '';
            document.getElementById(previewId).innerHTML = '';
        }

        // Form validation
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');

            if (!paymentMethod) {
                e.preventDefault();
                alert('Silakan pilih metode pembayaran!');
                return;
            }

            if (paymentMethod.value === 'bank_transfer' && !document.getElementById('bank_proof').files.length) {
                e.preventDefault();
                alert('Silakan upload bukti transfer!');
                return;
            }

            if (paymentMethod.value === 'qris' && !document.getElementById('qris_proof').files.length) {
                e.preventDefault();
                alert('Silakan upload bukti pembayaran QRIS!');
                return;
            }
        });
    </script>
</body>

</html>