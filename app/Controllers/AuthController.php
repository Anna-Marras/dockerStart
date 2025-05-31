<?php

namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);
    
            if (is_array($data)) {
                $user = new User();
                $user->setData($data);
    
                header('Content-Type: application/json');
                echo $user->register();
                exit; 
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => false,
                    "message" => "❌ Erreur de format JSON."
                ]);
                exit;
            }
        }

        require __DIR__ . '/../Views/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);
    
            if (isset($data['mail'], $data['password'])) {
                $user = new User();
                $user->setData($data);

                header('Content-Type: application/json');
                echo $user->login();
                exit; 
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => false,
                    "message" => "❌ Données manquantes."
                ]);
                exit;
            }
        }

        require __DIR__ . '/../Views/login.php';
    }

    public function logout() {
        session_start();
        session_unset(); 
        session_destroy(); 
        
        header('Location: ?page=login');
        exit;
    }
    
}
?>
