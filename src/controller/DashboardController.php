<?php
namespace App\Controller;

use App\Model\AdminModel;

class DashboardController {
    private $admodel;

    public function __construct() {
        $this->admodel = new AdminModel();
    }

    public function dashboard() {
        // Début de session sécurisé
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Vérification du rôle admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 1) {
            header('Location: /login');
            exit;
        }

        // Données pour le dashboard
        $data = [
            'users' => $this->admodel->getRecentUsers(),
            'logs' => $this->admodel->getLoginLogs(),
            'stats' => $this->admodel->getStats()
        ];

        // Chargement de la vue
        include __DIR__ . '/../view/dashboard.php';
    }
}