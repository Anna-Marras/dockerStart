<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ?page=home');
    exit;
}

$perPage = 10;
$page = max(1, intval($_GET['p'] ?? 1));
$offset = ($page - 1) * $perPage;

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');

$orderModel = new \App\Models\Orders();
$totalOrders = 0;
$orders = $orderModel->getFilteredOrders($search, $status, $perPage, $offset, $totalOrders);
$totalPages = max(1, ceil($totalOrders / $perPage));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Gestion des commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet" />
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
        <h1 class="text-3xl font-bold mb-6 text-center">Gestion des commandes</h1>

        <div class="mb-6 bg-white p-4 rounded shadow flex flex-wrap gap-4 items-end">
            <form method="get" action="" class="flex flex-wrap gap-4 items-end w-full">
                <input type="hidden" name="page" value="admin_orders">
                <input type="text" name="search" placeholder="Recherche client, email ou n° commande..." value="<?= htmlspecialchars($search) ?>" class="border rounded px-2 py-1 flex-1" />
                <select name="status" class="border rounded px-2 py-1">
                    <option value="">Tous statuts</option>
                    <?php
                    $statuses = ['en attente', 'payée', 'en préparation', 'expédiée', 'livrée', 'annulée'];
                    foreach ($statuses as $s) {
                        $selected = ($status === $s) ? 'selected' : '';
                        echo "<option value=\"$s\" $selected>".ucfirst($s)."</option>";
                    }
                    ?>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Filtrer</button>
            </form>
        </div>

        <?php foreach ($orders as $order): ?>
            <div class="bg-white rounded shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <span class="font-mono text-lg font-semibold">Commande n°<?= htmlspecialchars($order['order_number']) ?></span>
                        <div class="text-gray-600 text-sm">
                            Client : <?= htmlspecialchars($order['username']) ?> - <?= htmlspecialchars($order['mail']) ?><br />
                            Date : <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-semibold"><?= number_format($order['total_amount'], 2, ',', ' ') ?> €</div>
                        <span class="inline-block px-3 py-1 rounded 
                            <?php
                                switch($order['status']) {
                                    case 'payée': echo 'bg-green-500 text-white'; break;
                                    case 'en attente': echo 'bg-yellow-400 text-white'; break;
                                    case 'en préparation': echo 'bg-blue-400 text-white'; break;
                                    case 'expédiée': echo 'bg-purple-400 text-white'; break;
                                    case 'livrée': echo 'bg-gray-400 text-white'; break;
                                    case 'annulée': echo 'bg-red-500 text-white'; break;
                                    default: echo 'bg-gray-200 text-gray-800';
                                }
                            ?>">
                            <?= htmlspecialchars($order['status']) ?>
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <strong>Jeux commandés :</strong>
                    <ul class="flex flex-wrap gap-4 mt-2">
                        <?php foreach ($order['items'] as $item): ?>
                            <li class="flex items-center space-x-3 border rounded p-2 bg-gray-50">
                                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-14 h-14 object-cover rounded" />
                                <div>
                                    <div class="font-medium"><?= htmlspecialchars($item['name']) ?></div>
                                    <div class="text-gray-600 text-sm">Quantité : <?= $item['quantity'] ?></div>
                                </div>
                                <div class="ml-auto font-semibold"><?= number_format($item['price'], 2, ',', ' ') ?> €</div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <form method="post" action="?page=admin_orders_update" class="flex flex-wrap items-center gap-3">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>" />
                    <label for="status-<?= $order['id'] ?>" class="font-semibold">Modifier le statut :</label>
                    <select id="status-<?= $order['id'] ?>" name="status" class="border rounded px-3 py-1">
                        <?php
                        foreach ($statuses as $s):
                            $selected = ($order['status'] === $s) ? 'selected' : '';
                        ?>
                            <option value="<?= $s ?>" <?= $selected ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Modifier</button>
                </form>

                <?php if ($order['status'] !== 'annulée'): ?>
                    <form method="post" action="?page=admin_orders_update" onsubmit="return confirm('Annuler cette commande ?');" class="mt-3">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>" />
                        <input type="hidden" name="status" value="annulée" />
                        <button type="submit" class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700">Annuler la commande</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if (empty($orders)): ?>
            <p class="text-center text-gray-500">Aucune commande trouvée.</p>
        <?php endif; ?>

        <?php if ($totalPages > 1): ?>
            <div class="flex justify-center mt-8 space-x-2">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=admin_orders<?= $search ? '&search=' . urlencode($search) : '' ?><?= $status ? '&status=' . urlencode($status) : '' ?>&p=<?= $i ?>"
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