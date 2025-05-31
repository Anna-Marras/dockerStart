<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Orders {
    public function getOrdersByUser($userId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE idUser = ? ORDER BY order_date DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($orderId) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            SELECT oi.quantity, oi.price, g.name, g.image
            FROM order_items oi
            JOIN game g ON oi.game_id = g.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelOrder($orderId, $userId) {
    $pdo = Database::getInstance();
    $stmt = $pdo->prepare("UPDATE orders SET status = 'annulée' WHERE id = ? AND idUser = ? AND status IN ('en attente', 'payée', 'en préparation')");
    $stmt->execute([$orderId, $userId]);
    }
    
    public function getOrderById($orderId, $userId) {
    $pdo = Database::getInstance();
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND idUser = ?");
    $stmt->execute([$orderId, $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createOrder($userId, $cartItems) {
    $pdo = \App\Core\Database::getInstance();
    $pdo->beginTransaction();

    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item['price'];
    }

    $orderNumber = $this->generateOrderNumber();

    $stmt = $pdo->prepare("INSERT INTO orders (idUser, order_number, idPayment, order_date, status, total_amount) VALUES (?, ?, ?, NOW(), 'en attente', ?)");
    $stmt->execute([$userId, $orderNumber, 1, $total]);

    $orderId = $pdo->lastInsertId();

    $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, game_id, quantity, price) VALUES (?, ?, 1, ?)");
    foreach ($cartItems as $item) {
        $stmtItem->execute([$orderId, $item['id'], $item['price']]);
    }

    $pdo->commit();
    return $orderId;
}

private function generateOrderNumber($orderId = null) {
    $prefix = 'RG';
    $date = date('Ymd');
    $random = strtoupper(bin2hex(random_bytes(3)));
    $idPart = $orderId ? str_pad($orderId, 4, '0', STR_PAD_LEFT) : '';

    return $prefix . $date . '-' . $random . ($idPart ? '-' . $idPart : '');
}


public function getAllOrdersWithItems() {
    $pdo = \App\Core\Database::getInstance();
    $orders = $pdo->query("SELECT o.*, u.username, u.mail 
        FROM orders o 
        JOIN user u ON o.idUser = u.id
        ORDER BY o.order_date DESC")->fetchAll(\PDO::FETCH_ASSOC);

    foreach ($orders as &$order) {
        $stmt = $pdo->prepare("SELECT oi.*, g.name, g.image 
            FROM order_items oi 
            JOIN game g ON oi.game_id = g.id 
            WHERE oi.order_id = ?");
        $stmt->execute([$order['id']]);
        $order['items'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    unset($order);
    return $orders;
}

public function updateOrderStatus($orderId, $status) {
    $pdo = \App\Core\Database::getInstance();
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $orderId]);
}

public function getFilteredOrders($search = '', $status = '', $perPage = 10, $offset = 0, &$total = 0) {
    $pdo = \App\Core\Database::getInstance();
    $params = [];
    $where = [];

    if ($search) {
        $where[] = "(u.username LIKE ? OR u.mail LIKE ? OR o.order_number LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    if ($status) {
        $where[] = "o.status = ?";
        $params[] = $status;
    }
    $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    $sqlCount = "SELECT COUNT(*) FROM orders o JOIN user u ON o.idUser = u.id $whereSql";
    $stmtCount = $pdo->prepare($sqlCount);
    $stmtCount->execute($params);
    $total = $stmtCount->fetchColumn();

    $sql = "SELECT o.*, u.username, u.mail 
            FROM orders o 
            JOIN user u ON o.idUser = u.id
            $whereSql
            ORDER BY o.order_date DESC
            LIMIT $perPage OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    foreach ($orders as &$order) {
        $stmtItems = $pdo->prepare("SELECT oi.*, g.name, g.image 
            FROM order_items oi 
            JOIN game g ON oi.game_id = g.id 
            WHERE oi.order_id = ?");
        $stmtItems->execute([$order['id']]);
        $order['items'] = $stmtItems->fetchAll(\PDO::FETCH_ASSOC);
    }
    unset($order);
    return $orders;
}


}
?>