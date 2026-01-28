<?php
namespace App\Controllers\Admin;

use App\Helpers\DatabaseHelper;

class AdminOrderController {
    public function index() {
        $db = DatabaseHelper::getConnection();
        // Ambil data pesanan terbaru
        $orders = $db->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll(\PDO::FETCH_ASSOC);
        
        require_once dirname(__DIR__, 2) . '/Views/admin/order/index.php';
    }

    public function detail() {
        $db = DatabaseHelper::getConnection();
        $id = $_GET['id'];

        // Ambil data order
        $stmt = $db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        $order = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Ambil item produk dalam order tersebut
        $stmtItems = $db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmtItems->execute([$id]);
        $items = $stmtItems->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode(['order' => $order, 'items' => $items]);
    }

    public function updateStatus() {
        $db = DatabaseHelper::getConnection();
        $id = $_POST['id'];
        $status = $_POST['status']; // 'pending', 'processing', 'shipped', dll

        $stmt = $db->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$status, $id]);

        header('Location: /admin/orders?status=updated');
    }
}