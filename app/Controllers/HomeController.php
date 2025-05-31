<?php

namespace App\Controllers;

class HomeController {
    public function index() {
        $game = new \App\Models\Game();
        $consoleFilter = $_GET['console'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        $perPage = 6;
        $offset = ($page - 1) * $perPage;
        $games = $game->getGames($consoleFilter, $offset, $perPage);
        $totalGames = $game->countGames($consoleFilter);

        require __DIR__ . '/../Views/home.php';
    }
}

?>
