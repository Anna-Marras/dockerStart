<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen" style="background-color:#5aabff;">

   <nav
  class="w-full flex items-center justify-between px-4 h-16 overflow-visible border-b-4 border-black shadow-2xl"
  style="background-color: #ffe2ff; font-family: 'Press Start 2P', monospace;">
        <a href="?page=home"><div class="flex items-center space-x-2">
           <img src="public/assets/media/img/logo.png"alt="Logo"class="h-32 w-auto -mt-2">
        </div></a>
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
            <a href="?page=login">
                <svg class="h-6 w-6 text-gray-700 hover:text-blue-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M6 20c0-2.2 3.6-4 6-4s6 1.8 6 4" />
                </svg>
            </a>
        </div>
    </nav>

    <div class="flex justify-center items-center h-[calc(100vh-64px)]">
        <form id="registerForm" class="bg-white p-8 rounded shadow-md w-96 space-y-4">
            <input name="username" type="text" placeholder="Nom d'utilisateur" required class="w-full border p-2 rounded">
            <input name="mail" type="email" placeholder="Email" required class="w-full border p-2 rounded">
            <input name="password" type="password" placeholder="Mot de passe" required class="w-full border p-2 rounded">
            <input name="confirmPassword" type="password" placeholder="Confirmer le mot de passe" required class="w-full border p-2 rounded">
            <input name="adress" type="text" placeholder="Adresse" required class="w-full border p-2 rounded">
            <input name="phone_number" type="text" placeholder="Numéro de téléphone" required class="w-full border p-2 rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">S'inscrire</button>
            <div id="responseMessage" class="text-center text-sm mt-4"></div>
        </form>
    </div>

    <script src="/boutique-en-ligne/public/assets/js/script.js"></script>
    <script src="/boutique-en-ligne/public/assets/js/navbar.js"></script>
</body>
</html>