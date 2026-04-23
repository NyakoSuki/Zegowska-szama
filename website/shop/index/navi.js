"use strict";

const logo = document.querySelector(".logo");
const account = document.querySelector(".account");
const cart = document.querySelector(".cart");
const menu = document.querySelector(".menu");



logo.addEventListener('click', ()=>
{
    window.location.href = "";
})


account.addEventListener("click", () =>
{
    window.location.href = "../account/account.html";
});


cart.addEventListener('click', ()=>
{
    window.location.href = "../cart/cart.php";
})


menu.addEventListener('click', ()=>
{
    
})