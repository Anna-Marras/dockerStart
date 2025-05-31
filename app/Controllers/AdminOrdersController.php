<?php
namespace App\Controllers;

use App\Models\Orders;

class AdminOrdersController {
    public function index() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ?page=home');
            exit;
        }
        $orderModel = new Orders();
        $orders = $orderModel->getAllOrdersWithItems();
        require_once dirname(__DIR__) . '/Views/admin_orders.php';

        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');
        $totalOrders = 0;
        $orderModel = new Orders();
        $orders = $orderModel->getFilteredOrders($search, $status, $perPage, $offset, $totalOrders);
        $totalPages = ceil($totalOrders / $perPage);

    }

    public function updateStatus() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ?page=home');
            exit;
        }
        $orderId = intval($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? '';
        if ($orderId > 0 && in_array($status, ['en attente', 'payée', 'en préparation', 'expédiée', 'livrée', 'annulée'])) {
            $orderModel = new Orders();
            $orderModel->updateOrderStatus($orderId, $status);
        }
        header('Location: ?page=admin_orders');
        exit;
    }
    
}
?>