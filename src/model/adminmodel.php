<?php
namespace App\Model;

use App\Database\Database;

class AdminModel {
    private $db;
    private $pdo;

    public function __construct() {
        $this->db = new Database();
        $this->pdo = $this->db->getConnection();
    }

    public function getRecentUsers($limit = 5) {
        $stmt = $this->pdo->prepare("
            SELECT username, created_at 
            FROM users 
            ORDER BY created_at DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLoginLogs($limit = 10) {
        $stmt = $this->pdo->prepare("
            SELECT u.username, l.login_time 
            FROM sessions l
            JOIN users u ON l.user_id = u.id
            ORDER BY l.login_time DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getStats() {
        $stats = [];

        // Total utilisateurs
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM users");
        $stats['total_users'] = $stmt->fetchColumn();

        // Utilisateurs actifs
        $stmt = $this->pdo->query("SELECT COUNT(*) as active FROM users WHERE status = 'active'");
        $stats['active_users'] = $stmt->fetchColumn();

        // Nouveaux utilisateurs (30 derniers jours)
        $stmt = $this->pdo->query("
            SELECT COUNT(*) as new_users 
            FROM users 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        ");
        $stats['new_users_30_days'] = $stmt->fetchColumn();

        return $stats;
    }
}