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

        const homeCartQtyInp = document.getElementById('homeCartQtyInp');

        const productId = addToCartBtn.dataset.bsProductId;
        const homeCartIdInp = document.getElementById('homeCartIdInp');

        const productName = addToCartBtn.dataset.bsProductName;
        const homeCartNameInp = document.getElementById('homeCartNameInp');

        const productStock = addToCartBtn.dataset.bsProductStock;
        const homeCartLeftInp = document.getElementById('homeCartLeftInp');

        homeCartQtyInp.value = 1;
        homeCartIdInp.value = productId;
        homeCartNameInp.value = productName;
        homeCartLeftInp.value = productStock
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

    fetch(window.CONFIG.BACKEND_URL + "shop/cartAdd.php",
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