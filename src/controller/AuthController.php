<?php
namespace App\Controller;

use App\Model\User;

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            if (!$email) {
                $_SESSION['error'] = "Email invalide";
                header('Location: /login');
                exit();
            }

            $user = new User();
            $userData = $user->findByEmail($email);
            echo $userData['password'];
            // Vérification du mot de passe hashé
            if ($userData && $this->verifyPassword($password, $userData['password'])) {
                // Création de la session sécurisée
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['user_role'] = $userData['role_id'];
                $_SESSION['last_activity'] = time();
                
                // Régénération de l'ID de session pour prévenir la fixation de session
                session_regenerate_id(true);
                
                // Redirection selon le rôle
                if ($userData['role_id'] === 1) {
                    header('Location: /dashboard-admin');
                } else {
                    header('Location: /dashboard-user');
                }
                exit();
            } else {
                $_SESSION['error'] = "Identifiants incorrects";
                header('Location: /login');
                exit();
            }
        } else {
            // Affichage du formulaire de login
            include '../src/view/login.php';
        }
    }

    public function register($email, $password, $role = 'user') {
        $hashedPassword = $this->hashPassword($password);
        $user = new User();
        return $user->create($email, $hashedPassword, $role);
    }

    // Hashage du mot de passe
    private function hashPassword($password) {
        // Utilisation de PASSWORD_DEFAULT qui utilise actuellement bcrypt
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // Vérification du mot de passe
    private function verifyPassword($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
    }

    public function logout() {
        // Destruction sécurisée de la session
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header('Location: login');
        exit();
    }
}