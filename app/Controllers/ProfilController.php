<?php

namespace App\Controllers;

class ProfilController {
    public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header('Location: ?page=login');
            exit;
        }
        require __DIR__ . '/../Views/profil.php'; 
    }
    
}

?>