"use strict";

const logo = document.querySelector(".logo");
const account = document.querySelector(".account");
const cart = document.querySelector(".cart");
const menu = document.querySelector(".menu");



logo.addEventListener('click', ()=>
{
    window.location.href = "../../../shop/home/frontend/home.php";
})


account.addEventListener("click", () =>
{
    window.location.href = "../../../shop/account/frontend/account.php";
});


cart.addEventListener('click', ()=>
{
    window.location.href = "../../../shop/cart/frontend/cart.php";
})


menu.addEventListener('click', ()=>
{
    
})