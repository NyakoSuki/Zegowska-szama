"use strict";

const createForm = document.querySelectorAll(".createForm");

const adminUpdateToast = document.getElementById('adminUpdateToast');
const toast = bootstrap.Toast.getOrCreateInstance(adminUpdateToast);
const result = document.getElementById("adminUpdateResult");


createForm.forEach(form =>
{
    form.addEventListener("submit", (e)=>
    {
        e.preventDefault();
        const formData = new FormData(e.currentTarget, e.submitter);

        fetch(window.CONFIG.BACKEND_URL + "admin/productUpdate.php",
        {
            method: "POST",
            body: formData
        })
        .then(async (response) =>
        {
            const data = await response.json();
        
            if (!response.ok)
            {
                throw new Error(data.message);
            }
        
            return data;
        })
        .then((data) =>
        {
            result.innerHTML = data.message;
        })
        .catch((error) =>
        {
            result.innerHTML = error;
        })
        .finally(() =>
        {
            toast.show();
        });
    });
});


const productImgInput = document.getElementById("productImgInput");
const productImg = document.getElementById("productImg");

productImgInput.addEventListener("input", ()=>
{
    productImg.src = window.CONFIG.PUBLIC_URL + "img/products/" + productImgInput.value;
});