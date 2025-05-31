<?php

namespace App\Models;

use App\Core\Database;

class ShoppingCart {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); 
    }

    public function addToCart($gameId) {
        $stmt = $this->db->prepare("SELECT availability FROM game WHERE id = :id");
        $stmt->bindParam(':id', $gameId, \PDO::PARAM_INT);
        $stmt->execute();
        $availability = $stmt->fetchColumn();

        if (!$availability) {
            $_SESSION['error'] = "Ce jeu est actuellement indisponible.";
            return false;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (!in_array($gameId, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $gameId;
        }

        if (isset($_SESSION['user_id'])) {
            $sql = "INSERT INTO shoppingcart (idGame, idUser) VALUES (:game_id, :user_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':game_id', $gameId, \PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $_SESSION['user_id'], \PDO::PARAM_INT);
            $stmt->execute();
        }

        return true;
    }

    public function removeFromCart($gameId) {
        if (isset($_SESSION['user_id'])) {
            $sql = "DELETE FROM shoppingcart WHERE idGame = :gameId AND idUser = :userId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':gameId', $gameId, \PDO::PARAM_INT);
            $stmt->bindParam(':userId', $_SESSION['user_id'], \PDO::PARAM_INT);
            $stmt->execute();
        }

        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($id) use ($gameId) {
                return $id != $gameId;
            });
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }

    public function clearCart() {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $sql = "DELETE FROM shoppingcart WHERE idUser = :userId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
            $stmt->execute();
        }

        unset($_SESSION['cart']);
    }

    public function getCartItems() {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $sql = "SELECT g.id, g.name, g.price, g.image FROM shoppingcart sc
                    JOIN game g ON sc.idGame = g.id
                    WHERE sc.idUser = :userId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                return [];
            }
            $gameIds = implode(',', $_SESSION['cart']);
            $sql = "SELECT id, name, price, image FROM game WHERE id IN ($gameIds)";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
}
?>
