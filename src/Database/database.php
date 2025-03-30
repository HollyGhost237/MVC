<?php
namespace App\Database;

use PDO;
use PDOException;

class Database {
    private $host;
    private $database;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        // Récupération de la configuration
        $config = include dirname(__DIR__, 2) . '/config/database.php';
        
        $this->host = $config["host"];
        $this->database = $config["dbname"];
        $this->username = $config["username"];
        $this->password = $config["password"];

        $this->connect();
    }

    private function connect() {
        try {
            // Options de connexion PDO
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
            ];

            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4", 
                $this->username, 
                $this->password,
                $options
            );
        } catch (PDOException $e) {
            // Log de l'erreur plutôt que simplement l'afficher
            error_log("Erreur de connexion à la base de données : " . $e->getMessage());
            
            // Message générique pour l'utilisateur
            throw new \Exception("Impossible de se connecter à la base de données");
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    // Méthode pour fermer la connexion
    public function closeConnection() {
        $this->conn = null;
    }
}