<?php
if (!isset($_SESSION['user'])) {
    header('Location: ?page=login');
    exit;
}
$user = $_SESSION['user'];

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../Models/User.php';
    $userModel = new \App\Models\User();
    $userModel->setData([
        'username'        => $_POST['username'] ?? $user['username'],
        'mail'            => $_POST['mail'] ?? $user['mail'],
        'adress'          => $_POST['adress'] ?? $user['adress'],
        'phone_number'    => $_POST['phone_number'] ?? $user['phone_number'],
        'password'        => $_POST['password'] ?? '',
        'confirmPassword' => $_POST['confirmPassword'] ?? '',
    ]);

    $pdo = \App\Core\Database::getInstance();
    $stmt = $pdo->prepare("UPDATE user SET username=?, mail=?, adress=?, phone_number=? WHERE id=?");
    $stmt->execute([
        $_POST['username'],
        $_POST['mail'],
        $_POST['adress'],
        $_POST['phone_number'],
        $user['id']
    ]);

    if (!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
        if ($_POST['password'] === $_POST['confirmPassword']) {
            $stmt = $pdo->prepare("UPDATE user SET password=? WHERE id=?");
            $stmt->execute([
                password_hash($_POST['password'], PASSWORD_BCRYPT),
                $user['id']
            ]);
            $message = "✅ Informations et mot de passe mis à jour.";
            $success = true;
        } else {
            $message = "❌ Les mots de passe ne correspondent pas.";
        }
    } else {
        $message = "✅ Informations mises à jour.";
        $success = true;
    }

    $_SESSION['user']['username'] = $_POST['username'];
    $_SESSION['user']['mail'] = $_POST['mail'];
    $_SESSION['user']['adress'] = $_POST['adress'];
    $_SESSION['user']['phone_number'] = $_POST['phone_number'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paramètres du compte</title>
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


    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow mt-10">
        <h1 class="text-2xl font-bold mb-4 text-center">Paramètres du compte</h1>

        <?php if ($message): ?>
            <div class="mb-4 text-center <?= $success ? 'text-green-600' : 'text-red-600' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label class="block font-semibold mb-1">Nom d'utilisateur</label>
                <input type="text" name="username" required
                       value="<?= htmlspecialchars($user['username']) ?>"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
            </div>
            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="mail" required
                       value="<?= htmlspecialchars($user['mail']) ?>"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
            </div>
            <div>
                <label class="block font-semibold mb-1">Adresse</label>
                <input type="text" name="adress"
                       value="<?= htmlspecialchars($user['adress']) ?>"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
            </div>
            <div>
                <label class="block font-semibold mb-1">Numéro de téléphone</label>
                <input type="text" name="phone_number"
                       value="<?= htmlspecialchars($user['phone_number']) ?>"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
            </div>
            <hr class="my-4">
            <div>
                <label class="block font-semibold mb-1">Nouveau mot de passe</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
                       placeholder="Laisser vide pour ne pas changer">
            </div>
            <div>
                <label class="block font-semibold mb-1">Confirmer le nouveau mot de passe</label>
                <input type="password" name="confirmPassword"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
                       placeholder="Laisser vide pour ne pas changer">
            </div>
            <div class="text-center mt-6">
                <button type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>

    <script src="/boutique-en-ligne/public/assets/js/navbar.js"></script>
</body>
</html>