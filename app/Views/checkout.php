<?php
$user = $_SESSION['user'] ?? null;
$shoppingCart = new \App\Models\ShoppingCart();
$cartItems = $shoppingCart->getCartItems();

$taxRate = 0.20;
$totalHT = 0;
foreach ($cartItems as $item) {
    $totalHT += $item['price'];
}
$taxAmount = $totalHT * $taxRate;
$totalTTC = $totalHT + $taxAmount;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Finalisation de la commande</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
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

    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <?php if (!$user): ?>
            <p class="text-red-600 text-lg font-semibold mb-4">Vous devez être connecté pour passer une commande.</p>
            <a href="?page=login" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Se connecter</a>
        <?php elseif (empty($cartItems)): ?>
            <p class="text-gray-600 text-lg font-semibold mb-4">Votre panier est vide.</p>
            <a href="?page=shopping" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Retour au panier</a>
        <?php else: ?>
            <h1 class="text-2xl font-bold mb-4 text-center">Confirmation de commande</h1>
            <div class="mb-4 text-left">
                <h2 class="font-semibold mb-1">Adresse de livraison :</h2>
                <div class="mb-2"><?= htmlspecialchars($user['adress']) ?></div>
            </div>
            <div class="mb-4 text-left">
                <h2 class="font-semibold mb-1">Votre commande :</h2>
                <ul>
                    <?php foreach ($cartItems as $item): ?>
                        <li class="flex justify-between border-b py-1">
                            <span><?= htmlspecialchars($item['name']) ?></span>
                            <span><?= number_format($item['price'], 2, ',', ' ') ?> €</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="mt-2 text-right">
                    <div>Sous-total HT : <?= number_format($totalHT, 2, ',', ' ') ?> €</div>
                    <div>TVA (<?= $taxRate*100 ?> %) : <?= number_format($taxAmount, 2, ',', ' ') ?> €</div>
                    <div class="font-bold">Total TTC : <?= number_format($totalTTC, 2, ',', ' ') ?> €</div>
                </div>
            </div>
            <form method="post" action="?page=checkout" class="mb-4" id="checkout-form">
                <div class="mb-4 text-left">
                    <label for="payment" class="block font-semibold mb-1">Mode de paiement :</label>
                    <select name="payment" id="payment" class="border rounded px-2 py-1 w-full">
                        <option value="cb">Carte bancaire</option>
                        <option value="paypal">PayPal</option>
                        <option value="stripe">Stripe</option>
                    </select>
                    <div id="stripe-button-container" class="mt-4" style="display:none;">
                        <button id="stripe-checkout-btn" type="button" class="w-full px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                            Payer avec Stripe
                        </button>
                    </div>
                </div>
                <button type="submit" id="default-submit-btn" name="confirm_order" class="w-full px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Confirmer et payer
                </button>
            </form>

            <a href="?page=shopping" class="text-blue-600 underline">Retour au panier</a>
        <?php endif; ?>
    </div>

    <script src="/boutique-en-ligne/public/assets/js/navbar.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="/boutique-en-ligne/public/assets/js/stripe.js"></script>
</body>
</html>
