<?php
namespace App\Controllers;

use App\Models\User;

class AdminUsersController {
    public function index() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: ?page=home');
        exit;
    }

    $search = trim($_GET['search'] ?? '');
    $userModel = new \App\Models\User();
    if ($search) {
        $users = $userModel->searchUsers($search);
    } else {
        $users = $userModel->getAllUsers();
    }

    require_once dirname(__DIR__) . '/Views/admin_users.php';
    }


    public function delete() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ?page=home');
            exit;
        }

        $userId = intval($_POST['user_id'] ?? 0);
        if ($userId > 0) {
            $userModel = new User();
            $userModel->deleteUser($userId);
        }
        header('Location: ?page=admin_users');
        exit;
    }

    public function changeRole() {
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: ?page=home');
        exit;
    }
    $userId = intval($_POST['user_id'] ?? 0);
    $role = ($_POST['role'] === 'admin') ? 'admin' : 'user';
    if ($userId > 0) {
        $userModel = new \App\Models\User();
        $userModel->updateUserRole($userId, $role);
    }
    header('Location: ?page=admin_users');
    exit;
    }

    public function add() {
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: ?page=home');
        exit;
    }
    $username = trim($_POST['username'] ?? '');
    $mail = trim($_POST['mail'] ?? '');
    $password = $_POST['password'] ?? '';
    $adress = trim($_POST['adress'] ?? '');
    $phone = trim($_POST['phone_number'] ?? '');
    $role = ($_POST['role'] === 'admin') ? 'admin' : 'user';

    if ($username && $mail && $password) {
        $userModel = new \App\Models\User();
        $userModel->addUser($username, $mail, $password, $adress, $phone, $role);
    }
    header('Location: ?page=admin_users');
    exit;
    }


}
?>