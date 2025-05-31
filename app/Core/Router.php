<?php

namespace App\Core;

class Router {
    public function handleRequest() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); 
        }

        $page = $_GET['page'] ?? 'home';

        switch ($page) {
            case 'register':
                $controller = new \App\Controllers\AuthController();
                $controller->register();
                break;

            case 'login':
                $controller = new \App\Controllers\AuthController();
                $controller->login();
                break;

            case 'logout': 
                $controller = new \App\Controllers\AuthController();
                $controller->logout();
                break;

            case 'profil':
                $controller = new \App\Controllers\ProfilController();
                $controller->index(); 
                break;

            case 'welcome':
                require __DIR__ . '/../Views/welcome.php';
                break;

            case 'shopping':
                $controller = new \App\Controllers\CartController();
                $controller->showCart();
                break;
              
            case 'ajouter_panier':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
                    $controller = new \App\Controllers\CartController();
                    $controller->addToCart();  
                }
                break;

            case 'supprimer_panier':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
                    $controller = new \App\Controllers\CartController();
                    $controller->removeFromCart();  
                }
                break;

            case 'vider_panier':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
                    $controller = new \App\Controllers\CartController();
                    $controller->clearCart();  
                }
                break;

            case 'home':
            default:
                $controller = new \App\Controllers\HomeController();
                $controller->index(); 
                break;

            case 'admin':
                $controller = new \App\Controllers\AdminController();
                $controller->index();
                break;

            case 'admin_users':
                $controller = new \App\Controllers\AdminUsersController();
                $controller->index();
                break;

            case 'admin_users_delete':
                $controller = new \App\Controllers\AdminUsersController();
                $controller->delete();
                break;

            case 'admin_users_role':
                $controller = new \App\Controllers\AdminUsersController();
                $controller->changeRole();
                break;

            case 'admin_users_add':
                $controller = new \App\Controllers\AdminUsersController();
                $controller->add();
                break;

            case 'admin_orders':
                $controller = new \App\Controllers\AdminOrdersController();
                $controller->index();
                break;
            case 'admin_orders_update':
                $controller = new \App\Controllers\AdminOrdersController();
                $controller->updateStatus();
                break;
                
            case 'admin_products':
                $controller = new \App\Controllers\AdminProductsController();
                $controller->index();
                break;
            case 'admin_products_add':
                $controller = new \App\Controllers\AdminProductsController();
                $controller->add();
                break;
            case 'admin_products_edit':
                $controller = new \App\Controllers\AdminProductsController();
                $controller->edit();
                break;
            case 'admin_products_delete':
                $controller = new \App\Controllers\AdminProductsController();
                $controller->delete();
                break;
                
            case 'checkout':
                $controller = new \App\Controllers\CheckoutController();
                $controller->index();
                break;

            case 'autocomplete':
                $controller = new \App\Controllers\GameController();
                $controller->autocomplete();
                break;

            case 'game': 
                $controller = new \App\Controllers\GameController();
                $controller->show();
                break;
                
            case 'ajouter_panier_ajax':
                $controller = new \App\Controllers\CartController();
                $controller->addToCartAjax();
                break;
            
            case 'parametres':
                $controller = new \App\Controllers\ParametresController();
                $controller->index();
                break;

            case 'commandes':
                $controller = new \App\Controllers\CommandesController();
                $controller->index();
                break;

            case 'facture':
                $controller = new \App\Controllers\CommandesController();
                $controller->facture();
                break;

        }
    }
}

?>
