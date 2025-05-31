<?php
namespace App\Controllers;

use App\Models\Orders;

class CancelOrderController {
    public function index() {
        session_start();
        $userId = $_SESSION['user']['id'] ?? null;
        $orderId = $_POST['order_id'] ?? null;

        header('Content-Type: application/json');
        if (!$userId || !$orderId) {
            echo json_encode(['success' => false, 'message' => 'Paramètres manquants']);
            exit;
        }

        $ordersModel = new Orders();
        $ordersModel->cancelOrder($orderId, $userId);

        echo json_encode(['success' => true]);
        exit;
    }
}
?>