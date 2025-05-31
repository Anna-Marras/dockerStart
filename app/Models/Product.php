<?php
namespace App\Models;

class Product {
    public function getAllProducts() {
    $pdo = \App\Core\Database::getInstance();
    $stmt = $pdo->query("
        SELECT g.*, c.name AS console_name
        FROM game g
        LEFT JOIN console c ON g.idConsole = c.id
        ORDER BY g.id DESC
    ");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


    public function addProduct($name, $info, $image, $price, $quantity, $availability, $idConsole) {
    $pdo = \App\Core\Database::getInstance();
    $stmt = $pdo->prepare("INSERT INTO game (name, info, image, price, quantity, availability, idConsole, idUser) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $info, $image, $price, $quantity, $availability, $idConsole, 1]);
    }

    public function editProduct($id, $name, $info, $image, $price, $quantity, $availability, $idConsole) {
        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->prepare("UPDATE game SET name=?, info=?, image=?, price=?, quantity=?, availability=?, idConsole=? WHERE id=?");
        $stmt->execute([$name, $info, $image, $price, $quantity, $availability, $idConsole, $id]);
    }


    public function deleteProduct($id) {
        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM game WHERE id=?");
        $stmt->execute([$id]);
    }
    
    public function getFilteredProducts($search = '', $perPage = 10, $offset = 0, &$total = 0) {
    $pdo = \App\Core\Database::getInstance();
    $params = [];
    $where = '';

    if ($search) {
        $where = "WHERE g.name LIKE ? OR g.info LIKE ?";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    $sqlCount = "SELECT COUNT(*) FROM game g $where";
    $stmtCount = $pdo->prepare($sqlCount);
    $stmtCount->execute($params);
    $total = $stmtCount->fetchColumn();

    $sql = "SELECT g.*, c.name AS console_name
            FROM game g
            LEFT JOIN console c ON g.idConsole = c.id
            $where
            ORDER BY g.id DESC
            LIMIT $perPage OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

}
?>