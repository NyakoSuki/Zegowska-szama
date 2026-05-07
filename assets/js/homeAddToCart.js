"use strict";


const addToCartModal = document.getElementById("addToCartModal");
const modal = new bootstrap.Modal(addToCartModal);

if (addToCartModal)
{
    addToCartModal.addEventListener('show.bs.modal', event =>
    {
        const button = event.relatedTarget;
        const value = button.dataset.bsProductId;
        const input = document.getElementById('addToCartId');

        input.value = value;
    })
}


const form = document.getElementById("addToCartForm");
const result = document.getElementById("addToCartResult");

const addToCartToast = document.getElementById('addToCartToast');
const toast = bootstrap.Toast.getOrCreateInstance(addToCartToast);

form.addEventListener("submit", function(e)
{
    e.preventDefault();
    let formData = new FormData(this);

    fetch(window.CONFIG.CART_B_URL + "cartAdd.php",
    {
        method: "POST",
        body: formData
    })
    .then(() =>
    {
        if (window.location.pathname.includes("/frontend"))
        {
            result.innerHTML = "Pomyślnie dodano do koszyka";
            toast.show()
            modal.hide();
        }
    })
    .catch(error=>result.innerHTML = error);
});