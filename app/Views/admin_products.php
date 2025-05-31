<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ?page=home');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des jeux</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="min-h-screen" style="background-color:#5aabff;">
     <nav
  class="w-full flex items-center justify-between px-4 h-16 overflow-visible border-b-4 border-black shadow-2xl"
  style="background-color: #b6b9ff; font-family: 'Press Start 2P', monospace;">

    <a href="?page=home">
        <div class="flex items-center space-x-2">
            <img src="public/assets/media/img/logo.png"alt="Logo"class="h-32 w-auto -mt-2">
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

    <div class="max-w-6xl mx-auto py-8 space-y-6">
        <h1 class="text-3xl font-bold mb-6 text-center">Gestion des jeux</h1>

        <div class="mb-6 bg-white p-4 rounded shadow flex flex-wrap gap-4 items-end">
            <form method="get" action="" class="flex flex-wrap gap-4 items-end w-full">
                <input type="hidden" name="page" value="admin_products">
                <input type="text" name="search" placeholder="Recherche par nom ou description..." value="<?= htmlspecialchars($search ?? '') ?>" class="border rounded px-2 py-1 flex-1" />
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Rechercher</button>
            </form>
        </div>

        <div class="mb-6 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Ajouter un jeu</h2>
            <form method="post" action="?page=admin_products_add" class="flex flex-wrap gap-4 items-end">
                <input type="text" name="name" placeholder="Nom du jeu" required class="border rounded px-2 py-1 flex-1">
                <input type="text" name="info" placeholder="Description" class="border rounded px-2 py-1 flex-1">
                <input type="url" name="image" placeholder="URL image" class="border rounded px-2 py-1 flex-1">
                <input type="number" step="0.01" name="price" placeholder="Prix (€)" required class="border rounded px-2 py-1 w-32">
                <input type="number" name="quantity" placeholder="Quantité" required class="border rounded px-2 py-1 w-24">
                <select name="availability" class="border rounded px-2 py-1 w-32">
                    <option value="1">Disponible</option>
                    <option value="0">Indisponible</option>
                </select>
                <select name="idConsole" class="border rounded px-2 py-1 w-48" required>
                    <option value="">Console</option>
                    <?php foreach ($consoles as $console): ?>
                        <option value="<?= $console['id'] ?>"><?= htmlspecialchars($console['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Ajouter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Image</th>
                        <th class="px-4 py-2 border">Nom</th>
                        <th class="px-4 py-2 border">Description</th>
                        <th class="px-4 py-2 border">Prix</th>
                        <th class="px-4 py-2 border">Quantité</th>
                        <th class="px-4 py-2 border">Disponibilité</th>
                        <th class="px-4 py-2 border">Console</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr class="border-t">
                        <form method="post" action="?page=admin_products_edit">
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <td class="px-4 py-2 border">
                                <input type="url" name="image" value="<?= htmlspecialchars($product['image']) ?>" class="border rounded px-2 py-1 w-32">
                                <?php if ($product['image']): ?>
                                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-16 h-16 object-cover rounded mt-2" />
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="border rounded px-2 py-1 w-32" required>
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="text" name="info" value="<?= htmlspecialchars($product['info']) ?>" class="border rounded px-2 py-1 w-40">
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" class="border rounded px-2 py-1 w-20" required>
                            </td>
                            <td class="px-4 py-2 border">
                                <input type="number" name="quantity" value="<?= $product['quantity'] ?>" class="border rounded px-2 py-1 w-16" required>
                            </td>
                            <td class="px-4 py-2 border">
                                <select name="availability" class="border rounded px-2 py-1 w-28">
                                    <option value="1" <?= $product['availability'] ? 'selected' : '' ?>>Disponible</option>
                                    <option value="0" <?= !$product['availability'] ? 'selected' : '' ?>>Indisponible</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 border">
                                <select name="idConsole" class="border rounded px-2 py-1 w-32" required>
                                    <option value="">Console</option>
                                    <?php foreach ($consoles as $console): ?>
                                        <option value="<?= $console['id'] ?>" <?= ($product['idConsole'] == $console['id'] ? 'selected' : '') ?>>
                                            <?= htmlspecialchars($console['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="px-4 py-2 border flex flex-col gap-2">
                                <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 mb-1">Enregistrer</button>
                        </form>
                        <form method="post" action="?page=admin_products_delete" onsubmit="return confirm('Supprimer ce jeu ?');">
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">Supprimer</button>
                        </form>
                            </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="flex justify-center mt-8 space-x-2">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=admin_products<?= $search ? '&search=' . urlencode($search) : '' ?>&p=<?= $i ?>"
                       class="px-3 py-1 rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' ?> hover:bg-blue-400 hover:text-white transition">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="public/assets/js/navbar.js"></script>

</body>
</html>