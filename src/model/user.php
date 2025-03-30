<?php
namespace App\Model;

class User {
    private $pdo;

    public function __construct() {
        // Connexion à la base de données
        $this->pdo = new \PDO('mysql:host=localhost;dbname=brief3', 'root', '');
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        echo $email;
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($username, $email, $hashedPassword, $role = 'user') {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)");
        return $stmt->execute([
            "username"=> $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role_id' => $role
        ]);
    }

    public function update($id, $username, $email, $hashedPassword, $role, $status, $created_at) {
        try {
            // Requête SQL corrigée
            $sql = 'UPDATE `users` 
                    SET `username` = :username, 
                        `email` = :email, 
                        `password` = :hashedPassword, 
                        `role_id` = :role, 
                        `status` = :status, 
                        `created_at` = :created_at 
                    WHERE id = :id';
            
            // Préparation de la requête
            $stmt = $this->pdo->prepare($sql);
            
            // Exécution avec gestion des erreurs
            $result = $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':hashedPassword' => $hashedPassword,
                ':role' => $role,
                ':status' => $status,
                ':created_at' => $created_at,
                ':id' => $id
            ]);
    
            // Vérification du succès de la mise à jour
            if ($result === false) {
                throw new \Exception("Erreur lors de la mise à jour de l'utilisateur");
            }
    
            return $result;
        } catch (\PDOException $e) {
            // Gestion des erreurs de base de données
            error_log("Erreur de mise à jour utilisateur : " . $e->getMessage());
            return false;
        }
    }
}