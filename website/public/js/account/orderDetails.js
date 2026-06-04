"use strict";

// Loads order details into a modal on details button click

document.addEventListener("DOMContentLoaded", () => {
    const detailsBtn = document.querySelectorAll(".detailsBtn");

    detailsBtn.forEach(btn => {
        btn.addEventListener("click", () => {
            const orderId = btn.dataset.id;
            const modal = document.querySelector("#detailsModal .modal-body");
            modal.innerHTML = `
                <div class="text-center py-3">
                    <div class="spinner-border spinner-border-sm me-2"></div>
                    Ładowanie...
                </div>`;

            fetch(window.CONFIG.BACKEND_URL + "account/orderDetails.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "order_id=" + orderId
            })
            .then(res => res.text())
            .then(data => {
                modal.innerHTML = data;
            })
            .catch(() => {
                modal.innerHTML = "<p class='text-danger'>Błąd ładowania danych.</p>";
            });
        });
    });
});