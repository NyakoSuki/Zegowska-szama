"use strict";

document.addEventListener("DOMContentLoaded", () => 
{
    const menuBtn = document.querySelector(".menuBtn");
    const menu = document.querySelector(".menu");

    if (!menuBtn || !menu) return;

    menuBtn.addEventListener("click", () => 
    {
        menu.classList.toggle("menuDisabled");
    });
});


const products = document.querySelectorAll(".product");

const searchName = document.getElementById("searchName");
const minPrice = document.getElementById("minPrice");
const maxPrice = document.getElementById("maxPrice");

const available = document.getElementById("available");
const discount = document.getElementById("discount");
let onlyAvailable = false;
let onlyDiscount = false;

const resetBtn = document.getElementById("resetFilters");

available.addEventListener("click", ()=>
{
    if(onlyAvailable)
    {
        available.classList.add("opacity-50");
        onlyAvailable = false;
    }
    else
    {
        available.classList.remove("opacity-50");
        onlyAvailable = true;
    }
})

discount.addEventListener("click", ()=>
{
    if(onlyDiscount)
    {
        discount.classList.add("opacity-50");
        onlyDiscount = false;
    }
    else
    {
        discount.classList.remove("opacity-50");
        onlyDiscount = true;
    }
})

function filterProducts()
{
    const nameValue = searchName.value.toLowerCase();
    const min = parseFloat(minPrice.value) || 0;
    const max = parseFloat(maxPrice.value) || Infinity;

    products.forEach(product => 
    {
        const productName = product.dataset.name;
        const productPrice = product.dataset.price;
        const isAvailable = product.dataset.available === "1";
        const isDiscount = product.dataset.discount;

        const matchName = productName.includes(nameValue);
        const matchPrice = productPrice >= min && productPrice <= max;
        const matchAvailable = !onlyAvailable || isAvailable;
        const matchDiscount = !onlyDiscount || isDiscount;

        if (matchName && matchPrice && matchAvailable && matchDiscount)
        {
            product.parentElement.style.display = "block";
        } 
        else
        {
            product.parentElement.style.display = "none";
        }
    });
}

searchName.addEventListener("input", filterProducts);
minPrice.addEventListener("input", filterProducts);
maxPrice.addEventListener("input", filterProducts);

available.addEventListener("click", filterProducts);
discount.addEventListener("click", filterProducts);

resetBtn.addEventListener("click", () => 
{
    searchName.value = "";
    minPrice.value = "";
    maxPrice.value = "";
    onlyAvailable = false;
    onlyDiscount = false;
    available.classList.add("opacity-50");
    discount.classList.add("opacity-50");
    filterProducts();
});