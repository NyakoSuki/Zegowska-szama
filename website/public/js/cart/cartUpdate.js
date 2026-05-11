"use strict";

const incForm = document.querySelectorAll(".incForm");
const decForm = document.querySelectorAll(".decForm");
const removeForm = document.querySelectorAll(".removeForm");

const addToCartToast = document.getElementById('addToCartToast');
const toast = bootstrap.Toast.getOrCreateInstance(addToCartToast);
const result = document.getElementById("addToCartResult");

incForm.forEach(add =>
{
    add.addEventListener("submit", function(e)
    {
        e.preventDefault();
        
        let formData = new FormData(this);
        formData.append("action", "add");

        fetch(window.CONFIG.BACKEND_URL + "cart/cartUpdate.php",
        {
            method: "POST",
            body: formData
        })
        .then(() =>
        {
            if (window.location.pathname.includes("/public"))
            {
                window.location.reload();
            }
        })
        .catch(error=>console.log(error));
    });
});


decForm.forEach(remove =>
{
    remove.addEventListener("submit", function(e)
    {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append("action", "remove");

        fetch(window.CONFIG.BACKEND_URL + "cart/cartUpdate.php",
        {
            method: "POST",
            body: formData
        })
        .then(() =>
        {
            if (window.location.pathname.includes("/public"))
            {
                window.location.reload();
            }
        })
        .catch(error=>console.log(error));
    });
});


removeForm.forEach(trash =>
{
    trash.addEventListener("submit", function(e)
    {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append("action", "trash");

        fetch(window.CONFIG.BACKEND_URL + "cart/cartUpdate.php",
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
            sessionStorage.setItem("toastMessage", text);

            window.location.reload();
        })
        .catch(error =>
        {
            sessionStorage.setItem("toastMessage", error.message);

            window.location.reload();
        });
    });
});


const qtyInp = document.querySelectorAll(".qtyInp");
qtyInp.forEach(qty => 
{
    qty.addEventListener("blur", ()=>
    {
        let formData = new FormData();
        formData.append("action", "update");
        formData.append("id", qty.dataset.productId);
        formData.append("quantity", qty.value);

        fetch(window.CONFIG.BACKEND_URL + "cart/cartUpdate.php",
        {
            method: "POST",
            body: formData
        })
        .then((text) =>
        {
            window.location.reload();
        })
    });
});

window.addEventListener("DOMContentLoaded", () =>
{
    const message = sessionStorage.getItem("toastMessage");
    const type = sessionStorage.getItem("toastType");

    if (!message) return;

    const result = document.getElementById("addToCartResult");
    const toastEl = document.getElementById("addToCartToast");
    const toast = new bootstrap.Toast(toastEl);

    result.innerHTML = message;

    toast.show();

    sessionStorage.removeItem("toastMessage");
    sessionStorage.removeItem("toastType");
});