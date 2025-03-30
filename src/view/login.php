<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Connexion - Tableau de Bord Admin</title>
</head>
<body class="bg-gray-100">
    <section class="h-screen flex items-center justify-center">
        <div class="w-full max-w-md">
            <h1 class="text-3xl text-center font-extrabold uppercase mb-6 text-green-600">Connectez-vous</h1>
            
            <!-- Formulaire -->
            <form action="/login" method="POST" class="bg-white p-8 rounded-lg shadow-md space-y-4">
                <!-- Email (remplacé le nom par email) -->
                <div>
                    <label for="email" class="block text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Entrez votre email" 
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-gray-700 mb-2">Mot de Passe</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Votre mot de passe" 
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                </div>

                <!-- Bouton de connexion -->
                <div>
                    <button 
                        type="submit" 
                        class="w-full bg-green-600 text-white py-3 rounded-md hover:bg-green-700 transition duration-300"
                    >
                        Se Connecter
                    </button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>