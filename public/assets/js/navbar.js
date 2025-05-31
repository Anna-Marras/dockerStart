document.addEventListener("DOMContentLoaded", () => {
    const searchIconBtn = document.getElementById("searchIconBtn");
    const searchBarContainer = document.getElementById("searchBarContainer");
    const searchInput = searchBarContainer ? searchBarContainer.querySelector("input") : null;

    if (searchIconBtn && searchBarContainer && searchInput) {
        searchIconBtn.addEventListener("click", () => {
            searchBarContainer.classList.toggle("hidden");
            if (!searchBarContainer.classList.contains("hidden")) {
                searchInput.focus();
            }
        });
    }

    const profileIconBtn = document.getElementById("profileIconBtn");
    const profileDropdownMenu = document.getElementById("profileDropdownMenu");
    if (profileIconBtn && profileDropdownMenu) {
        let open = false;
        profileIconBtn.addEventListener("click", (e) => {
            e.preventDefault();
            open = !open;
            if (open) {
                profileDropdownMenu.classList.remove("opacity-0", "pointer-events-none");
                profileDropdownMenu.classList.add("opacity-100");
            } else {
                profileDropdownMenu.classList.add("opacity-0", "pointer-events-none");
                profileDropdownMenu.classList.remove("opacity-100");
            }
        });
        document.addEventListener("click", (e) => {
            if (
                open &&
                !profileIconBtn.contains(e.target) &&
                !profileDropdownMenu.contains(e.target)
            ) {
                profileDropdownMenu.classList.add("opacity-0", "pointer-events-none");
                profileDropdownMenu.classList.remove("opacity-100");
                open = false;
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById('navbarSearchInput');
    const suggestionsBox = document.getElementById('searchSuggestions');
    let selectedGameId = null; 

    if (searchInput && suggestionsBox) {
        let timeout = null;

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            selectedGameId = null; 
            clearTimeout(timeout);
            if (query.length < 2) {
                suggestionsBox.innerHTML = '';
                suggestionsBox.classList.add('hidden');
                return;
            }
            timeout = setTimeout(() => {
                fetch(`/boutique-en-ligne/?page=autocomplete&term=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionsBox.innerHTML = '';
                        if (data.length === 0) {
                            suggestionsBox.classList.add('hidden');
                            return;
                        }
                        data.forEach(game => {
                            const li = document.createElement('li');
                            li.textContent = game.name;
                            li.className = 'px-3 py-2 cursor-pointer hover:bg-blue-100';
                            li.addEventListener('mousedown', function(e) {
                                e.preventDefault();
                                searchInput.value = game.name;
                                selectedGameId = game.id; 
                                suggestionsBox.innerHTML = '';
                                suggestionsBox.classList.add('hidden');
                            });
                            suggestionsBox.appendChild(li);
                        });
                        suggestionsBox.classList.remove('hidden');
                    });
            }, 200);
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.classList.add('hidden');
            }
        });

        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const query = searchInput.value.trim();
            if (selectedGameId) {
                window.location.href = `/boutique-en-ligne/?page=game&id=${selectedGameId}`;
            } else if (query.length > 0) {
                window.location.href = `/boutique-en-ligne/?page=home&search=${encodeURIComponent(query)}`;
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const gameId = this.getAttribute('data-game-id');
            fetch('/boutique-en-ligne/?page=ajouter_panier_ajax', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `game_id=${encodeURIComponent(gameId)}`
            })
            .then(response => response.json())
            .then(data => {
                showToast(data.success ? data.message : "Erreur lors de l'ajout.", data.success);
            })
            .catch(() => {
                showToast("Erreur lors de l'ajout.", false);
            });
        });
    });

    function showToast(message, success = true) {
        const toast = document.getElementById('toast-panier');
        if (!toast) return;
        toast.textContent = message;
        toast.classList.remove('hidden');
        toast.classList.remove('bg-green-600', 'bg-red-600');
        toast.classList.add(success ? 'bg-green-600' : 'bg-red-600');
        toast.style.opacity = '1';

        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.classList.add('hidden'), 300);
        }, 2000);
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const btn = document.getElementById('addToCartBtn');
    if (btn) {
        btn.addEventListener('click', function() {
            const gameId = btn.getAttribute('data-game-id');
            fetch('/boutique-en-ligne/?page=ajouter_panier_ajax', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `game_id=${encodeURIComponent(gameId)}`
            })
            .then(response => response.json())
            .then(data => {
                showToast(data.success ? data.message : "Erreur lors de l'ajout.", data.success);
            })
            .catch(() => {
                showToast("Erreur lors de l'ajout.", false);
            });
        });
    }

    function showToast(message, success = true) {
        const toast = document.getElementById('toast-panier');
        if (!toast) return;
        toast.textContent = message;
        toast.classList.remove('hidden');
        toast.classList.remove('bg-green-600', 'bg-red-600');
        toast.classList.add(success ? 'bg-green-600' : 'bg-red-600');
        toast.style.opacity = '1';

        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.classList.add('hidden'), 300);
        }, 2000);
    }
});