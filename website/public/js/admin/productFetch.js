"use strict";

const createForm = document.querySelectorAll(".createForm");

createForm.forEach(form => {
    

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
            throw new Error(data);
        }
    
        return data;
    })
    .then((data) =>
    {
        // success
        console.log(data);
    })
    .catch((error) =>
    {
        // error
        console.log(error);
    })
    .finally(() =>
    {
        // cleanup
        window.location.reload();
    });
});
});


const productImgInput = document.getElementById("productImgInput");
const productImg = document.getElementById("productImg");

productImgInput.addEventListener("input", ()=>
{
    productImg.src = window.CONFIG.PUBLIC_URL + "img/products/" + productImgInput.value;
});