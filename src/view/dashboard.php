<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard Administrateur</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-green-600">Tableau de Bord Administrateur</h1>
        
        <div class="grid grid-cols-3 gap-6">
            <!-- Statistiques -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Statistiques Utilisateurs</h2>
                <div class="space-y-2">
                    <p>Nombre total d'utilisateurs : <span class="font-bold"><?= $data['stats']['total_users'] ?></span></p>
                    <p>Utilisateurs actifs : <span class="font-bold"><?= $data['stats']['active_users'] ?></span></p>
                    <p>Nouveaux utilisateurs (30 jours) : <span class="font-bold"><?= $data['stats']['new_users_30_days'] ?></span></p>
                </div>
            </div>

            <!-- Historique de Connexion -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Dernières Connexions</h2>
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left">Utilisateur</th>
                            <th class="text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['logs'] as $log): ?>
                        <tr class="border-b">
                            <td><?= htmlspecialchars($log['username']) ?></td>
                            <td><?= htmlspecialchars($log['login_time']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Utilisateurs Récents -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Utilisateurs Récents</h2>
                <ul class="space-y-2">
                    <?php foreach ($data['users'] as $user): ?>
                    <li class="flex justify-between">
                        <span><?= htmlspecialchars($user['username']) ?></span>
                        <span class="text-gray-500"><?= htmlspecialchars($user['created_at']) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>