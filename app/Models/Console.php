<?php
namespace App\Models;

class Console {
    public function getAllConsoles() {
        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM console ORDER BY name ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>