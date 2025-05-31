<?php
namespace App\Controllers;

use App\Models\Product;

class AdminProductsController {
    public function index() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: ?page=home');
        exit;
    }
    $perPage = 10;
    $page = max(1, intval($_GET['p'] ?? 1));
    $offset = ($page - 1) * $perPage;
    $search = trim($_GET['search'] ?? '');

    $productModel = new \App\Models\Product();
    $totalProducts = 0;
    $products = $productModel->getFilteredProducts($search, $perPage, $offset, $totalProducts);

    $consoleModel = new \App\Models\Console();
    $consoles = $consoleModel->getAllConsoles();

    $totalPages = max(1, ceil($totalProducts / $perPage));

    require_once dirname(__DIR__) . '/Views/admin_products.php';
}



    public function add() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: ?page=home');
        exit;
    }
    $name = trim($_POST['name'] ?? '');
    $info = trim($_POST['info'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    $availability = intval($_POST['availability'] ?? 0);
    $idConsole = intval($_POST['idConsole'] ?? 0);

    if ($name && $price > 0 && $idConsole > 0) {
        $productModel = new Product();
        $productModel->addProduct($name, $info, $image, $price, $quantity, $availability, $idConsole);
    }
    header('Location: ?page=admin_products');
    exit;
}

    public function edit() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ?page=home');
            exit;
        }
        $id = intval($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $info = trim($_POST['info'] ?? '');
        $image = trim($_POST['image'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 0);
        $availability = intval($_POST['availability'] ?? 0);
        $idConsole = intval($_POST['idConsole'] ?? 0);

        if ($id > 0 && $name && $price > 0 && $idConsole > 0) {
            $productModel = new Product();
            $productModel->editProduct($id, $name, $info, $image, $price, $quantity, $availability, $idConsole);
        }
        header('Location: ?page=admin_products');
        exit;
    }


    public function delete() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ?page=home');
            exit;
        }
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            $productModel = new Product();
            $productModel->deleteProduct($id);
        }
        header('Location: ?page=admin_products');
        exit;
    }
}
?>