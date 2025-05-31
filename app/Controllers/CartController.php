<?php

namespace App\Controllers;

use App\Models\ShoppingCart;

class CartController {

    public function addToCart() {
    if (isset($_POST['game_id'])) {
        $gameId = (int)$_POST['game_id']; 
        $cart = new ShoppingCart();

        $pdo = \App\Core\Database::getInstance();
        $stmt = $pdo->prepare("SELECT availability FROM game WHERE id = ?");
        $stmt->execute([$gameId]);
        $availability = $stmt->fetchColumn();

        if (!$availability) {
            $_SESSION['error'] = "Ce jeu est actuellement indisponible.";
            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php?page=home'));
            exit;
        }

        if (isset($_SESSION['user_id'])) {
            $cart->addToCart($gameId);  
        } else {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            if (!in_array($gameId, $_SESSION['cart'])) {
                $_SESSION['cart'][] = $gameId;  
            }
        }

        header('Location: index.php?page=panier');
        exit;
    }
}


    public function removeFromCart() {
        if (isset($_POST['remove_game_id'])) {
            $gameId = (int)$_POST['remove_game_id'];
            $cart = new ShoppingCart();
            $cart->removeFromCart($gameId);
        }
        header('Location: ?page=shopping');  
        exit;
    }

    public function clearCart() {
        $cart = new ShoppingCart();
        $cart->clearCart();
        header('Location: ?page=shopping');
        exit;
    }

    public function showCart() {
        $cart = new \App\Models\ShoppingCart();
        $cartItems = $cart->getCartItems();
        require __DIR__ . '/../Views/shopping.php'; 
    }

    public function addToCartAjax() {
        header('Content-Type: application/json');
        $response = ['success' => false, 'message' => 'Erreur inconnue'];
    
        if (isset($_POST['game_id'])) {
            $gameId = (int)$_POST['game_id'];
            $cart = new \App\Models\ShoppingCart();
    
            if (isset($_SESSION['user_id'])) {
                $cart->addToCart($gameId);
            } else {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                if (!in_array($gameId, $_SESSION['cart'])) {
                    $_SESSION['cart'][] = $gameId;
                }
            }
            $response = ['success' => true, 'message' => 'Jeu ajouté au panier !'];
        } else {
            $response['message'] = "Aucun jeu sélectionné.";
        }
    
        echo json_encode($response);
        exit;
    }
    
    
}
?>
