<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique en ligne</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/styles/style.css">
</head>
<body class="bg-gray-100">

     <nav
  class="w-full flex items-center justify-between px-4 h-16 overflow-visible border-b-4 border-black shadow-2xl"
  style="background-color: #ffe2ff; font-family: 'Press Start 2P', monospace;">

    <a href="?page=home">
        <div class="flex items-center space-x-2">
            <img src="public/assets/media/img/logo.png"alt="Logo"class="h-32 w-auto -mt-2" style="z-index : 1;">
        </div>
    </a>
    <div id="searchBarContainer" class="flex-1 mx-4 hidden relative">
        <form id="searchForm" class="flex items-center" autocomplete="off">
            <input
                id="navbarSearchInput"
                type="text"
                placeholder="Rechercher un produit..."
                class="w-full border border-gray-300 rounded-l px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
            >
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-r hover:bg-blue-600 transition">
                Rechercher
            </button>
        </form>
        <ul id="searchSuggestions" class="absolute left-0 right-0 bg-white border border-gray-300 rounded-b shadow z-50 hidden"></ul>
    </div>
    <div class="flex items-center space-x-6">
        <button id="searchIconBtn" class="focus:outline-none">
            <svg class="h-6 w-6 text-gray-700 hover:text-blue-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
        </button>
        <a href="?page=shopping" class="relative">
            <svg class="h-6 w-6 text-gray-700 hover:text-blue-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                <circle cx="9" cy="21" r="1" />
                <circle cx="20" cy="21" r="1" />
            </svg>
        </a>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
            <a href="?page=admin" class="px-3 py-2 text-white bg-gray-800 rounded hover:bg-gray-900 font-bold">Admin</a>
        <?php endif; ?>
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


<div class="flex min-h-screen">
  <aside id="sidebar" class="fixed top-16 bottom-0 left-0 z-40 w-64 transform -translate-x-full
         transition-transform duration-300 border-r-4 border-black shadow-2xl p-6"
  style="background-color: #ffe2ff; font-family: 'Press Start 2P', monospace;" >
  
    <button id="sidebarToggle" class="absolute top-4 -right-6 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l-7 7 7 7" />
      </svg>
    </button>
                <h2 class="text-xl font-bold">Filtres</h2>
                <form method="GET">
                    <div class="mt-4">
                        <label for="console" class="block text-sm font-medium text-gray-700">Console</label>
                        <select name="console" id="console" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Tous</option>
                            <option value="NES" <?php echo isset($_GET['console']) && $_GET['console'] == 'NES' ? 'selected' : ''; ?>>NES</option>
                            <option value="SNES" <?php echo isset($_GET['console']) && $_GET['console'] == 'SNES' ? 'selected' : ''; ?>>SNES</option>
                            <option value="SEGA" <?php echo isset($_GET['console']) && $_GET['console'] == 'SEGA' ? 'selected' : ''; ?>>SEGA</option>
                            <option value="GameBoy" <?php echo isset($_GET['console']) && $_GET['console'] == 'Gamboy' ? 'selected' : ''; ?>>GameBoy</option>
                            <option value="Playstation1" <?php echo isset($_GET['console']) && $_GET['console'] == 'Playstation1' ? 'selected' : ''; ?>>Playstation1</option>
                            <option value="Nintendo64" <?php echo isset($_GET['console']) && $_GET['console'] == 'Nintendo64' ? 'selected' : ''; ?>>Nintendo64</option>
                        </select>
                    </div>
                    <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Appliquer</button>
                </form>
        </aside>

            <div class="flex-1">
                <video autoplay muted loop id="myVideo" class="w-full h-48 sm:h-64 md:h-80 lg:h-96 object-cover rounded-lg shadow-lg">
                    <source src="public/assets/media/vid/back3.mp4" type="video/mp4">
                </video>
                <div class="max-w-screen-xl mx-auto px-4 py-8">
                <!-- <h1 class="text-3xl font-bold mb-6"><img src="public/assets/media/img/back.png" alt="" ></h1> -->

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 ">
                    <?php
                    use App\Models\Game;

                    $consoleFilter = isset($_GET['console']) ? $_GET['console'] : '';

                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  
                    $page = max(1, $page);  
                    
                    $perPage = 9; 
                    $offset = ($page - 1) * $perPage; 

                    $game = new Game();
                    $games = $game->getGames($consoleFilter, $offset, $perPage);

                    foreach ($games as $g) {
                        echo '
                        <div class="flip-card group w-full max-w-xs mx-auto">
                        <div class="flip-card-inner relative w-full h-80 transition-transform duration-500 transform group-hover:rotate-y-180">
                            <!-- Face avant -->
                            <div class="flip-card-front w-40 h-40 absolute w-full h-full backface-hidden rounded-lg overflow-hidden shadow-lg">
                            <img src="' . htmlspecialchars($g['image']) . '" alt="' . htmlspecialchars($g['name']) . '" class="w-full h-full object-cover" />
                            </div>
                            <!-- Face arrière -->
                            <div class="flip-card-back absolute w-full h-full backface-hidden rounded-lg overflow-hidden shadow-lg bg-white flex flex-col justify-center items-center p-4 rotate-y-180">
                            <h3 class="text-lg font-semibold text-center">' . htmlspecialchars($g['name']) . '</h3>
                            <p class="text-sm text-gray-600 text-center mt-2">' . htmlspecialchars($g['info']) . '</p>
                            <p class="text-xl font-bold mt-2">€' . number_format($g['price'], 2) . '</p>';
                            if (!empty($g['availability'])) {
                                echo '<button class="add-to-cart-btn mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600" data-game-id="' . $g['id'] . '" type="button" style="background-color:#5aabff;">Ajouter au panier</button>
                                <span class="add-to-cart-feedback text-green-600 ml-2" style="display:none;"></span>';
                            } else {
                                echo '<button class="mt-4 px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed" type="button" disabled>Indisponible</button>';
                            }
                        echo '
                            </div>
                        </div>
                        </div>';
                    }
                    ?>
                </div>
                <div id="toast-panier" class="fixed bottom-6 right-6 bg-green-600 text-black px-6 py-3 rounded shadow-lg z-50 hidden transition-opacity duration-300" style="background-color:#ffe2ff;">
                    Jeu ajouté au panier !
                </div>
                <div class="mt-8">
                    <nav aria-label="Page navigation">
                        <ul class="flex justify-center space-x-4">
                            <?php
                            $totalGames = $game->countGames($consoleFilter);
                            $totalPages = ceil($totalGames / $perPage);

                            $maxPagesToShow = 4;
                            $start = max(1, $page - floor($maxPagesToShow / 2));
                            $end = min($totalPages, $start + $maxPagesToShow - 1);

                            
                            if ($end - $start + 1 < $maxPagesToShow) {
                                $start = max(1, $end - $maxPagesToShow + 1);
                            }

                            if ($page > 1) {
                                echo '<li><a href="?page=' . ($page - 1) . '&console=' . $consoleFilter . '" class="px-4 py-2 bg-gray-300 rounded">Précédent</a></li>';
                            }

                            if ($start > 1) {
                                echo '<li><a href="?page=1&console=' . $consoleFilter . '" class="px-4 py-2 rounded bg-gray-300">1</a></li>';
                                if ($start > 2) {
                                    echo '<li><span class="px-4 py-2">...</span></li>';
                                }
                            }

                            for ($i = $start; $i <= $end; $i++) {
                                $active = ($i == $page) ? 'bg-blue-500 text-white' : 'bg-gray-300';
                                echo '<li><a href="?page=' . $i . '&console=' . $consoleFilter . '" class="px-4 py-2 rounded ' . $active . '">' . $i . '</a></li>';
                            }

                            if ($end < $totalPages) {
                                if ($end < $totalPages - 1) {
                                    echo '<li><span class="px-4 py-2">...</span></li>';
                                }
                                echo '<li><a href="?page=' . $totalPages . '&console=' . $consoleFilter . '" class="px-4 py-2 rounded bg-gray-300">' . $totalPages . '</a></li>';
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
<script src="/public/assets/js/sidebar.js"></script>
</body>
</html>