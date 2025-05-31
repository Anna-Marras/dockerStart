<?php

namespace App\Controllers;

use App\Models\Orders;

class CommandesController {
    public function index() {
    if (!isset($_SESSION['user'])) {
        header('Location: ?page=login');
        exit;
    }
    $userId = $_SESSION['user']['id'];
    $orderModel = new Orders();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order_id'])) {
        $orderId = intval($_POST['cancel_order_id']);
        $orderModel->cancelOrder($orderId, $userId);
        header('Location: ?page=commandes&msg=cancelled');
        exit;
    }

    $orders = $orderModel->getOrdersByUser($userId);
    foreach ($orders as &$order) {
        $order['items'] = $orderModel->getOrderItems($order['id']);
    }
    unset($order);

    require_once dirname(__DIR__) . '/Views/commandes.php';
}


    public function facture() {
    if (!isset($_SESSION['user'])) {
        header('Location: ?page=login');
        exit;
    }
    $userId = $_SESSION['user']['id'];
    $orderId = intval($_GET['id'] ?? 0);
    $orderModel = new \App\Models\Orders();
    $order = $orderModel->getOrderById($orderId, $userId);
    if (!$order) {
        echo "Commande introuvable.";
        exit;
    }
    $order['items'] = $orderModel->getOrderItems($orderId);
    require_once dirname(__DIR__) . '/Views/facture.php';
}

}
?>