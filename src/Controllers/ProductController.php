<?php

namespace App\Controllers;

use App\Helpers\DatabaseHelper;

class ProductController
{
    /**
     * Menampilkan Halaman Marketplace untuk Publik
     */
    public function index()
    {
        try {
            $db = DatabaseHelper::getConnection();

            // Mengambil semua produk untuk dipajang di Marketplace
            $stmt = $db->query("SELECT * FROM products ORDER BY created_at DESC");
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Path menuju file View Publik
            require_once dirname(__DIR__) . '/Views/products/index.php';
        } catch (\PDOException $e) {
            die("Gagal memuat marketplace: " . $e->getMessage());
        }
    }

    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /product');
            exit;
        }

        try {
            $db = DatabaseHelper::getConnection();
            $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$product) {
                die("Produk tidak ditemukan.");
            }

            // Ambil produk lain sebagai rekomendasi
            $stmtRelated = $db->prepare("SELECT * FROM products WHERE id != ? LIMIT 3");
            $stmtRelated->execute([$id]);
            $relatedProducts = $stmtRelated->fetchAll(\PDO::FETCH_ASSOC);

            require_once dirname(__DIR__) . '/Views/products/detail.php';
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function addToCart()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id = $_POST['id'];
        $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Jika produk sudah ada di keranjang, tambahkan qty
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += $qty;
        } else {
            // Jika produk belum ada, tambahkan baru
            $_SESSION['cart'][$id] = [
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'image' => $_POST['image'],
                'qty' => $qty
            ];
        }

        // Return JSON untuk AJAX
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'cart_count' => array_sum(array_column($_SESSION['cart'], 'qty'))
            ]);
            exit;
        }

        header('Location: ' . ($_POST['redirect'] ?? '/product'));
    }

    public function updateCart()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id = $_POST['id'];
        $new_qty = (int)$_POST['qty'];

        if (isset($_SESSION['cart'][$id])) {
            if ($new_qty > 0) {
                $_SESSION['cart'][$id]['qty'] = $new_qty;
            } else {
                unset($_SESSION['cart'][$id]);
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }

    public function removeFromCart()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id = $_POST['id'];

        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }

    public function cart()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $cart = $_SESSION['cart'] ?? [];
        require_once dirname(__DIR__) . '/Views/products/cart.php';
    }

    public function checkout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $db = DatabaseHelper::getConnection();

                // Validasi data
                $name = $_POST['name'] ?? '';
                $phone = $_POST['phone'] ?? '';
                $address = $_POST['address'] ?? '';
                $payment_method = $_POST['payment_method'] ?? '';

                if (empty($name) || empty($phone) || empty($address) || empty($payment_method)) {
                    throw new \Exception("Semua field harus diisi!");
                }

                if (empty($_SESSION['cart'])) {
                    throw new \Exception("Keranjang belanja kosong!");
                }

                // Hitung total
                $total = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $total += $item['price'] * $item['qty'];
                }

                // Simpan order ke database
                $stmt = $db->prepare("
                    INSERT INTO orders (customer_name, phone, address, payment_method, total_price, status, created_at) 
                    VALUES (?, ?, ?, ?, ?, 'pending', NOW())
                ");
                $stmt->execute([$name, $phone, $address, $payment_method, $total]);
                $orderId = $db->lastInsertId();

                // Simpan detail order
                foreach ($_SESSION['cart'] as $productId => $item) {
                    $stmt = $db->prepare("
                        INSERT INTO order_items (order_id, product_id, product_name, price, quantity) 
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([$orderId, $productId, $item['name'], $item['price'], $item['qty']]);
                }

                // Kosongkan keranjang
                unset($_SESSION['cart']);

                // Redirect ke halaman riwayat pesanan
                header('Location: /products/orders?success=1');
                exit;
            } catch (\Exception $e) {
                $_SESSION['checkout_error'] = $e->getMessage();
                header('Location: /products/cart');
                exit;
            }
        }

        // Jika GET request, tampilkan form checkout
        $cart = $_SESSION['cart'] ?? [];
        require_once dirname(__DIR__) . '/Views/products/checkout.php';
    }

    public function orders()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Di sistem nyata, Anda perlu login user
        // Untuk sementara kita ambil semua orders (atau filter by session)
        try {
            $db = DatabaseHelper::getConnection();

            // Ambil semua orders (atau filter berdasarkan user yang login)
            $stmt = $db->query("SELECT * FROM orders ORDER BY created_at DESC");
            $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            require_once dirname(__DIR__) . '/Views/products/orders.php';
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function orderDetail()
    {
        // 1. Ambil ID pesanan dari URL
        $orderId = $_GET['id'] ?? null;

        if (!$orderId) {
            header('Location: /products/orders');
            exit;
        }

        try {
            // Panggil koneksi database (Sesuai pola fungsi lainnya di controller ini)
            $db = DatabaseHelper::getConnection();

            // 2. Ambil data utama pesanan (Tabel orders)
            $stmtOrder = $db->prepare("SELECT * FROM orders WHERE id = ?");
            $stmtOrder->execute([$orderId]);
            $order = $stmtOrder->fetch(\PDO::FETCH_ASSOC);

            if (!$order) {
                die("Pesanan tidak ditemukan.");
            }

            // 3. Ambil data item pesanan (Tabel order_items)
            $stmtItems = $db->prepare("SELECT * FROM order_items WHERE order_id = ?");
            $stmtItems->execute([$orderId]);
            $items = $stmtItems->fetchAll(\PDO::FETCH_ASSOC);

            // 4. Kirim kedua variabel tersebut ke View
            require_once dirname(__DIR__) . '/Views/products/order-detail.php';
            
        } catch (\PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
