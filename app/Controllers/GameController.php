<?php
namespace App\Controllers;

use App\Models\Game;

class GameController {
    public function autocomplete() {
        header('Content-Type: application/json');
        $term = $_GET['term'] ?? '';
        $game = new Game();
        $results = $game->searchByName($term);
        echo json_encode($results);
        exit;
    }    

    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "Jeu introuvable.";
            exit;
        }
        $gameModel = new \App\Models\Game();
        $game = $gameModel->getGameById($id);
        if (!$game) {
            echo "Jeu introuvable.";
            exit;
        }
        require __DIR__ . '/../Views/game_detail.php';
    }
    
}
?>