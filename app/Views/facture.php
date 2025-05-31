<?php
if (!isset($order)) {
    echo "Aucune facture à afficher.";
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture - Commande n°<?= $order['id'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: #fff; }
        }
    </style>
</head>
<body class="min-h-screen" style="background-color:#5aabff;">

<nav
  class="w-full flex items-center justify-between px-4 h-16 overflow-visible border-b-4 border-black shadow-2xl"
  style="background-color: #ffe2ff; font-family: 'Press Start 2P', monospace;">
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

    <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow mt-10">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">Facture</h1>
            <span>Commande n°<?= htmlspecialchars($order['order_number']) ?></span>
        </div>

        <div class="mb-6">
            <div class="font-semibold">Informations client :</div>
            <div><?= htmlspecialchars($user['username']) ?> (<?= htmlspecialchars($user['mail']) ?>)</div>
            <div><?= htmlspecialchars($user['adress']) ?></div>
            <div><?= htmlspecialchars($user['phone_number']) ?></div>
        </div>

        <div class="mb-6">
            <div class="font-semibold">Date de la commande :</div>
            <div><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></div>
        </div>

        <div class="mb-6">
            <div class="font-semibold">Adresse de livraison :</div>
            <div><?= htmlspecialchars($order['shipping_adress'] ?? $user['adress']) ?></div>
        </div>

        <div class="mb-6">
            <div class="font-semibold">Détail de la commande :</div>
            <table class="w-full mt-2 border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-2 py-1 text-left">Jeu</th>
                        <th class="px-2 py-1 text-left">Prix unitaire</th>
                        <th class="px-2 py-1 text-left">Quantité</th>
                        <th class="px-2 py-1 text-left">Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td class="px-2 py-1"><?= htmlspecialchars($item['name']) ?></td>
                        <td class="px-2 py-1"><?= number_format($item['price'], 2, ',', ' ') ?> €</td>
                        <td class="px-2 py-1"><?= $item['quantity'] ?></td>
                        <td class="px-2 py-1"><?= number_format($item['price'] * $item['quantity'], 2, ',', ' ') ?> €</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-right text-xl font-bold">
            Total : <?= number_format($order['total_amount'], 2, ',', ' ') ?> €
        </div>

        <div class="mt-8 text-center no-print">
            <button onclick="window.print()" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Imprimer la facture</button>
            <a href="?page=commandes" class="ml-4 text-blue-600 underline">Retour à mes commandes</a>
        </div>
    </div>
</body>
</html>