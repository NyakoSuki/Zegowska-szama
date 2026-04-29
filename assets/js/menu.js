"use strict";

const menuBtn = document.querySelector(".menuBtn");
const menu = document.querySelector(".menu");

menuBtn.addEventListener('click', () => 
{
    menu.classList.toggle("menuDisabled");
});



const searchName = document.getElementById("searchName");
const minPrice = document.getElementById("minPrice");
const maxPrice = document.getElementById("maxPrice");
const available = document.getElementById("available");
const products = document.querySelectorAll(".product");
const resetBtn = document.getElementById("resetFilters");

function filterProducts()
{
    const nameValue = searchName.value.toLowerCase();
    const min = parseFloat(minPrice.value) || 0;
    const max = parseFloat(maxPrice.value) || Infinity;
    const onlyAvailable = available.checked;

    products.forEach(product => 
    {
        const productName = product.dataset.name;
        const productPrice = product.dataset.price;
        const isAvailable = product.dataset.available === "1";

        const matchName = productName.includes(nameValue);
        const matchPrice = productPrice >= min && productPrice <= max;
        const matchAvailable = !onlyAvailable || isAvailable;

        if (matchName && matchPrice && matchAvailable)
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
available.addEventListener("change", filterProducts);

resetBtn.addEventListener("click", () => 
{
    searchName.value = "";
    minPrice.value = "";
    maxPrice.value = "";
    available.checked = false;
    filterProducts();
});