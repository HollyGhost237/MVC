<?php
require_once '../vendor/autoload.php';

use App\Controller\AuthController;
use App\Controller\DashboardController;

// Gestion des sessions
session_start();

// Récupération de l'URL
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Routage simple
switch ($request) {
    case '/login':
        echo'brj';
        $controller = new AuthController();
        $controller->login();
        break;
        case '/dashboard-admin':
            $controller = new DashboardController();
        $controller->dashboard();
        break;
        default:
        // Page 404
        http_response_code(404);
        echo "L'URL est : ".$request;
        echo "Page non trouvée";
        break;
}