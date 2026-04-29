"use strict";

const cartAdd = document.querySelectorAll(".cartAdd");
const cartRemove = document.querySelectorAll(".cartRemove");

cartAdd.forEach(add =>
{
    add.addEventListener("submit", function(e)
    {
        e.preventDefault();

        let formData = new FormData(this);

        fetch(window.CONFIG.CART_B_URL + "cart-add.php",
        {
            method: "POST",
            body: formData
        })
        .then(() =>
        {
            if (window.location.pathname.includes("/cart"))
            {
                window.location.reload();
            }
        })
        .catch(error=>console.log(error));
    });
});


cartRemove.forEach(remove =>
{
    remove.addEventListener("submit", function(e)
    {
        e.preventDefault();

        let formData = new FormData(this);

        fetch(window.CONFIG.CART_B_URL + "cart-remove.php",
        {
            method: "POST",
            body: formData
        })
        .then(() => location.reload())
        .catch(error=>console.log(error));
    });
});