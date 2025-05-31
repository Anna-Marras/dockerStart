<?php

namespace App\Controllers;

class AdminController {
    public function index() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ?page=home');
            exit;
        }
        require_once dirname(__DIR__) . '/Views/admin.php';
    }
}
?>