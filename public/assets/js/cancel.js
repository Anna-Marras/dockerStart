document.querySelectorAll('.annuler-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const orderId = this.dataset.orderId;
        fetch('?page=cancel_order', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'order_id=' + encodeURIComponent(orderId)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('statut-' + orderId).textContent = 'annulée';
                this.disabled = true;
                this.textContent = 'Annulée';
            } else {
                alert('Erreur : ' + data.message);
            }
        });
    });
});