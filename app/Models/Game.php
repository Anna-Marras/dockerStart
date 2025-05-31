<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Game {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getGames($consoleFilter = '', $offset = 0, $perPage = 6) {
        $consoleMapping = [
            'NES' => 1,
            'SNES' => 2,
            'SEGA' => 3,
            'GameBoy' => 4,
            'Playstation1' => 5,
            'Nintendo64' => 6,
        ];
    
        if ($consoleFilter && isset($consoleMapping[$consoleFilter])) {
            $consoleFilter = $consoleMapping[$consoleFilter];
        } else {
            $consoleFilter = '';
        }
    
        $sql = "SELECT * FROM game";
        $params = [];
    
        if ($consoleFilter) {
            $sql .= " WHERE idConsole = :console"; 
            $params['console'] = $consoleFilter;
        }
    
        $sql .= " LIMIT :offset, :perPage";
    
        $stmt = $this->db->prepare($sql);
    
        if ($consoleFilter) {
            $stmt->bindParam(':console', $params['console'], PDO::PARAM_INT);
        }
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    

    public function countGames($consoleFilter = '') {
        $consoleMapping = [
            'NES' => 1,
            'SNES' => 2,
            'SEGA' => 3,
            'GameBoy' => 4,
            'Playstation1' => 5,
            'Nintendo64' => 6,
        ];
    
        if ($consoleFilter && isset($consoleMapping[$consoleFilter])) {
            $consoleFilter = $consoleMapping[$consoleFilter];
        } else {
            $consoleFilter = '';  
        }
    
        $sql = "SELECT COUNT(*) FROM game";
        $params = [];
    
        if ($consoleFilter) {
            $sql .= " WHERE idConsole = :console";
            $params['console'] = $consoleFilter;
        }
    
        $stmt = $this->db->prepare($sql);
        if ($consoleFilter) {
            $stmt->bindParam(':console', $params['console'], PDO::PARAM_INT);
        }
        $stmt->execute();
    
        return $stmt->fetchColumn();
    }
    
    public function searchByName($term) {
        $sql = "SELECT id, name FROM game WHERE name LIKE :term LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $like = '%' . $term . '%';
        $stmt->bindParam(':term', $like, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); 
    }
    
    public function getGameById($id) {
        $sql = "SELECT game.*, console.name AS console_name 
                FROM game 
                JOIN console ON game.idConsole = console.id
                WHERE game.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }  
}
?>
