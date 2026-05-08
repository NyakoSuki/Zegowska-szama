"use strict";

/**
* ====================HOME====================
 * fill modal
 * get data from modal
 * add to cart
 * sgow toast
* ==================================================
*/
const cartAddModal = document.getElementById("cartAddModal");
const modal = new bootstrap.Modal(cartAddModal);

if (cartAddModal)
{
    cartAddModal.addEventListener('show.bs.modal', event =>
    {
        const addToCartBtn = event.relatedTarget;

        const addToCartQuantity = document.getElementById('addToCartQuantity');

        const productId = addToCartBtn.dataset.bsProductId;
        const productIdInput = document.getElementById('addToCartId');

        const productName = addToCartBtn.dataset.bsProductName;
        const productNameInput = document.getElementById('addToCartName');

        addToCartQuantity.value = 1;
        productIdInput.value = productId;
        productNameInput.value = productName;
    })
}


const form = document.getElementById("addToCartForm");
const result = document.getElementById("addToCartResult");

const cartAddToast = document.getElementById('cartAddToast');
const toast = bootstrap.Toast.getOrCreateInstance(cartAddToast);

form.addEventListener("submit", function(e)
{
    e.preventDefault();

    let formData = new FormData(this);

    fetch(window.CONFIG.SHARED_URL + "cartAdd.php",
    {
        method: "POST",
        body: formData
    })
    .then(async response =>
    {
        const text = await response.text();

        if (!response.ok)
        {
            throw new Error(text);
        }

        return text;
    })
    .then((text) =>
    {
        result.innerHTML = text

        toast.show();
        modal.hide();
    })
    .catch(error =>
    {
        result.innerHTML = error.message;
        toast.show();
    });
});


/**
* ====================CART====================
 * 
* ==================================================
*/