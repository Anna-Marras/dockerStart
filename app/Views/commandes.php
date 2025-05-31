<?php
if (!isset($_SESSION['user'])) {
    header('Location: ?page=login');
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes commandes</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow mt-10">
        <h1 class="text-2xl font-bold mb-4 text-center">Mes commandes</h1>

        <?php if (empty($orders)): ?>
            <p class="text-center text-gray-500">Vous n'avez pas encore passé de commande.</p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="mb-6 border-b pb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <span>Commande n°<?= htmlspecialchars($order['order_number']) ?></span>
                            <span class="ml-4 text-gray-500">du <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></span>
                        </div>
                        <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-sm"><?= htmlspecialchars($order['status']) ?></span>
                    </div>
                    <?php
                    $steps = ['en attente', 'payée', 'en préparation', 'expédiée', 'livrée'];
                    $currentStep = array_search($order['status'], $steps);
                    ?>
                    <div class="flex space-x-2 mt-2">
                        <?php foreach ($steps as $i => $step): ?>
                            <span class="px-2 py-1 rounded <?= $i <= $currentStep ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600' ?>">
                                <?= $step ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-2 text-gray-700">
                        <strong>Montant total :</strong> <?= number_format($order['total_amount'], 2, ',', ' ') ?> €
                        <?php if ($order['shipping_adress']): ?>
                            <br><strong>Livraison :</strong> <?= htmlspecialchars($order['shipping_adress']) ?>
                        <?php endif; ?>
                    </div>
                    <div class="mt-2">
                        <strong>Jeux commandés :</strong>
                        <ul class="mt-1 space-y-2">
                            <?php foreach ($order['items'] as $item): ?>
                                <li class="flex items-center space-x-3">
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-12 h-12 object-cover rounded">
                                    <span class="font-medium"><?= htmlspecialchars($item['name']) ?></span>
                                    <span class="text-gray-500">x<?= $item['quantity'] ?></span>
                                    <span class="ml-auto"><?= number_format($item['price'], 2, ',', ' ') ?> €</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <br>
                    <?php if (in_array($order['status'], ['en attente', 'payée', 'en préparation'])): ?>
                        <form method="post" action="?page=commandes" class="inline">
                            <input type="hidden" name="cancel_order_id" value="<?= $order['id'] ?>">
                            <button class="annuler-btn px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600" data-order-id="<?= $order['id'] ?>">Annuler</button>
                        </form>
                    <?php endif; ?>
                </div>
                <a href="?page=facture&id=<?= $order['id'] ?>" class="ml-2 text-blue-600 underline text-sm">Télécharger la facture</a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="/boutique-en-ligne/public/assets/js/navbar.js"></script>
    <script src="/boutique-en-ligne/public/assets/js/cancel.js"></script>
</body>
</html>