<?php

require_once '../app/Core/Autoloader.php';

use App\Core\Router;

$router = new Router();
$router->handleRequest();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique en ligne</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow px-4 py-2 flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" alt="Logo" class="h-8 w-8">
            <span class="font-bold text-xl text-gray-800">MaBoutique</span>
        </div>
        <div id="searchBarContainer" class="flex-1 mx-4 hidden">
            <form id="searchForm" class="flex items-center">
                <input
                    type="text"
                    placeholder="Rechercher un produit..."
                    class="w-full border border-gray-300 rounded-l px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
                >
                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-r hover:bg-blue-600 transition">
                    Rechercher
                </button>
            </form>
        </div>
        <div class="flex items-center space-x-6">
            <button id="searchIconBtn" class="focus:outline-none">
                <svg class="h-6 w-6 text-gray-700 hover:text-blue-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </button>
            <a href="shopping.php" class="relative">
                <svg class="h-6 w-6 text-gray-700 hover:text-blue-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                    <circle cx="9" cy="21" r="1" />
                    <circle cx="20" cy="21" r="1" />
                </svg>
            </a>
            <?php if (isset($_SESSION['user'])): ?>
            <div class="relative group" id="profileDropdownContainer">
                <button id="profileIconBtn" class="focus:outline-none flex items-center">
                    <svg class="h-6 w-6 text-gray-700 hover:text-blue-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M6 20c0-2.2 3.6-4 6-4s6 1.8 6 4" />
                    </svg>
                    <svg class="h-4 w-4 ml-1 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition duration-200 z-50"
                    id="profileDropdownMenu">
                    <a href="?page=profil" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Informations</a>
                    <a href="?page=parametres" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Paramètres</a>
                    <a href="?page=commandes" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Mes commandes</a>
                    <a href="?page=logout" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Déconnexion</a>
                </div>
            </div>
            <?php else: ?>
            <a href="?page=login">
                <svg class="h-6 w-6 text-gray-700 hover:text-blue-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M6 20c0-2.2 3.6-4 6-4s6 1.8 6 4" />
                </svg>
            </a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8">

        <div class="flex">
            <div class="w-1/4 bg-white p-4 rounded shadow-lg">
                <h2 class="text-xl font-bold">Filtres</h2>
                <form method="GET" action="index.php">
                    <div class="mt-4">
                        <label for="console" class="block text-sm font-medium text-gray-700">Console</label>
                        <select name="console" id="console" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Tous</option>
                            <option value="NES" <?php echo isset($_GET['console']) && $_GET['console'] == 'NES' ? 'selected' : ''; ?>>NES</option>
                            <option value="SNES" <?php echo isset($_GET['console']) && $_GET['console'] == 'SNES' ? 'selected' : ''; ?>>SNES</option>
                        </select>
                    </div>
                    <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Appliquer</button>
                </form>
            </div>

            <div class="w-3/4 pl-8">
                <h1 class="text-3xl font-bold mb-4">Jeux en vente</h1>

                <div class="grid grid-cols-3 gap-4">
                    <?php
                    use App\Models\Game;

                    $consoleFilter = isset($_GET['console']) ? $_GET['console'] : '';

                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  
                    $page = max(1, $page);  
                    
                    $perPage = 6; 
                    $offset = ($page - 1) * $perPage; 

                    $game = new Game();
                    $games = $game->getGames($consoleFilter, $offset, $perPage);

                    foreach ($games as $g) {
                        echo '<div class="bg-white p-4 rounded shadow-lg">';
                        echo '<img src="' . $g['image'] . '" alt="' . $g['name'] . '" class="w-full h-40 object-cover mb-4 rounded">';
                        echo '<h3 class="text-lg font-semibold">' . $g['name'] . '</h3>';
                        echo '<p class="text-sm text-gray-600">' . $g['info'] . '</p>';
                        echo '<p class="text-xl font-bold mt-2">€' . number_format($g['price'], 2) . '</p>';
                    
                        echo '<form method="POST" action="index.php?page=ajouter_panier">';
                        echo '<input type="hidden" name="game_id" value="' . $g['id'] . '">';
                        echo '<button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Ajouter au panier</button>';
                        echo '</form>';
                    
                        echo '</div>';
                    }
                    ?>
                </div>

                <div class="mt-8">
                    <nav aria-label="Page navigation">
                        <ul class="flex justify-center space-x-4">
                            <?php
                            $totalGames = $game->countGames($consoleFilter);
                            $totalPages = ceil($totalGames / $perPage);

                            if ($page > 1) {
                                echo '<li><a href="?page=' . ($page - 1) . '&console=' . $consoleFilter . '" class="px-4 py-2 bg-gray-300 rounded">Précédent</a></li>';
                            }

                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li><a href="?page=' . $i . '&console=' . $consoleFilter . '" class="px-4 py-2 bg-gray-300 rounded">' . $i . '</a></li>';
                            }

                            if ($page < $totalPages) {
                                echo '<li><a href="?page=' . ($page + 1) . '&console=' . $consoleFilter . '" class="px-4 py-2 bg-gray-300 rounded">Suivant</a></li>';
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/assets/js/navbar.js"></script>

</body>
</html>
