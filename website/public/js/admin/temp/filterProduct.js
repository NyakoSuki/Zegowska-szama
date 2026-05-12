"use strict";

const productSearchAvailable = document.getElementById("productSearchAvailable");
let productState = 2;


productSearchAvailable.addEventListener("click", ()=>
{
    productState = (productState + 1) % 3;

    switch (productState)
    {
        case 0 : showUnactive(); break;
        case 1 : showActive(); break;
        case 2 : showAll(); break;
    }
});

function showAll()
{
    productSearchAvailable.textContent = "Wyświetla wszystkie";
    productSearchAvailable.classList.add("btn-info");
    productSearchAvailable.classList.remove("btn-success");
    productSearchAvailable.classList.remove("btn-danger");
}

function showActive()
{
    productSearchAvailable.textContent = "Wyświetla dostępne";
    productSearchAvailable.classList.add("btn-success");
    productSearchAvailable.classList.remove("btn-danger");
}

function showUnactive()
{
    productSearchAvailable.textContent = "Wyświetla niedostępne";
    productSearchAvailable.classList.add("btn-danger");
    productSearchAvailable.classList.remove("btn-info");
}



const products = document.querySelectorAll(".productList");
const productsResetBtn = document.getElementById("productResetBtn");

const productSearchName = document.getElementById("productSearchName");
const productSearchMin = document.getElementById("productSearchMin");
const productSearchMax = document.getElementById("productSearchMax");


function filterProducts()
{
    const nameValue = productSearchName.value.toLowerCase();
    const minValue = parseFloat(productSearchMin.value) || 0;
    const maxValue = parseFloat(productSearchMax.value) || Infinity;

    products.forEach(product => 
    {
        const productName = product.dataset.name;
        const productPrice = product.dataset.price;
        const productActive = product.dataset.available;

        const matchName = productName.includes(nameValue);
        const matchPrice = productPrice >= minValue && productPrice <= maxValue;
        const matchAvailable = (Number(productActive) === productState || productState == 2);

        if (matchName && matchPrice && matchAvailable)
        {
            product.style.display = "block";
        }
        else
        {
            product.style.display = "none";
        }
    });
}

productSearchName.addEventListener("input", filterProducts);
productSearchMin.addEventListener("input", filterProducts);
productSearchMax.addEventListener("input", filterProducts);

productSearchAvailable.addEventListener("click", filterProducts);

productsResetBtn.addEventListener("click", () => 
{
    productSearchName.value = "";
    productSearchMin.value = "";
    productSearchMax.value = "";
    productState = 2;
    showAll();
    filterProducts();
});





const productSelect = document.getElementById("productSelect");

productSelect.addEventListener("change", () => 
{
    const selected = productSelect.options[productSelect.selectedIndex];

    if (!selected.value) return;

    document.getElementById("productId").value = selected.dataset.id || "";
    document.getElementById("productName").value = selected.dataset.name || "";
    document.getElementById("productPrice").value = selected.dataset.price || null;
    document.getElementById("productType").value = selected.dataset.type || "none";
    document.getElementById("productStock").value = selected.dataset.stock || null;
    document.getElementById("productDescription").value = selected.dataset.description || "";
    document.getElementById("productImg").value = selected.dataset.img || "";
    document.getElementById("productAvailable").checked = selected.dataset.available === "1";
    document.getElementById("productActive").checked = selected.dataset.active === "1";
});



const productSaveBtn = document.getElementById("productSaveBtn");
const productAddBtn = document.getElementById("productAddBtn");
const productId = document.getElementById("productId");
const productIdNext = document.getElementById("productIdNext");
const addSwitchValue = document.getElementById("addSwitchValue");

document.getElementById("productAdd").addEventListener("change", ()=>
{
    productAddBtn.classList.toggle("d-none");
    productSaveBtn.classList.toggle("d-none");

    productId.classList.toggle("d-none");
    productIdNext.classList.toggle("d-none");

    addSwitchValue.value = addSwitchValue.value === "update" ? "add" : "update";
})