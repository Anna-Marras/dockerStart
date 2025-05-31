<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ?page=home');
    exit;
}
$search = htmlspecialchars($_GET['search'] ?? '');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
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
    <div class="max-w-5xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Gestion des utilisateurs</h1>
        
        <div class="mb-4 flex flex-wrap gap-2 items-center">
            <form method="get" action="" class="flex gap-2">
                <input type="hidden" name="page" value="admin_users">
                <input type="text" name="search" placeholder="Rechercher par nom ou email..." value="<?= $search ?>" class="border rounded px-2 py-1">
                <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Rechercher</button>
            </form>
        </div>

        <div class="mb-6 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Ajouter un utilisateur</h2>
            <form method="post" action="?page=admin_users_add" class="flex flex-wrap gap-4 items-end">
                <input type="text" name="username" placeholder="Nom d'utilisateur" required class="border rounded px-2 py-1">
                <input type="email" name="mail" placeholder="Email" required class="border rounded px-2 py-1">
                <input type="password" name="password" placeholder="Mot de passe" required class="border rounded px-2 py-1">
                <input type="text" name="adress" placeholder="Adresse" class="border rounded px-2 py-1">
                <input type="text" name="phone_number" placeholder="Téléphone" class="border rounded px-2 py-1">
                <select name="role" class="border rounded px-2 py-1">
                    <option value="user">user</option>
                    <option value="admin">admin</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Ajouter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nom d'utilisateur</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Adresse</th>
                        <th class="px-4 py-2">Téléphone</th>
                        <th class="px-4 py-2">Rôle</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="border-t">
                        <td class="px-4 py-2"><?= htmlspecialchars($user['id']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($user['username']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($user['mail']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($user['adress']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($user['phone_number']) ?></td>
                        <td class="px-4 py-2">
                            <span class="inline-block px-2 py-1 rounded <?= $user['role'] === 'admin' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
                                <?= htmlspecialchars($user['role']) ?>
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
                                <form method="post" action="?page=admin_users_role" class="inline">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <select name="role" class="border rounded px-2 py-1 text-sm">
                                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>user</option>
                                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>admin</option>
                                    </select>
                                    <button type="submit" class="ml-2 px-2 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Changer</button>
                                </form>
                                <form method="post" action="?page=admin_users_delete" class="inline" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="ml-2 px-2 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">Supprimer</button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-400 text-sm">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="/boutique-en-ligne/public/assets/js/navbar.js"></script>

</body>
</html>