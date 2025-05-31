<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct() {
        // Récupération des paramètres via les variables d'environnement (compatibles Docker)
        $host = getenv('DB_HOST') ?: 'db';
        $db   = getenv('DB_NAME') ?: 'boutique';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASSWORD') ?: '';

        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$db;charset=utf8",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            // Affichage propre de l'erreur (à améliorer en prod)
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Singleton : une seule instance partagée partout dans l'appli
    public static function getInstance(): PDO {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}
