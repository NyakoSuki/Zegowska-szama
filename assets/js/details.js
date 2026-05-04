"use strict";

const detailsBtn = document.querySelectorAll(".detailsBtn");
console.log("details.js loaded");
detailsBtn.forEach(btn =>
{
    btn.addEventListener("click", ()=>
    {
        console.log("details.js loaded");
        const orderId = btn.dataset.id;
        const modal = document.querySelector("#detailsModal .modal-body");
        modal.innerHTML = "Ładowanie...";

        fetch(window.CONFIG.ACCOUNT_B_URL + "details.php",
        {
            method: "POST",
            headers:
            {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "order_id=" + orderId
        })
        .then(res => res.text())
        .then(data =>
        {
            modal.innerHTML = data;
        });
    });
});