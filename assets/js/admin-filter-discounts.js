"use strict";

const discountSearchAvailable = document.getElementById("discountSearchAvailable");
let discountState = 2;
console.log("e");


discountSearchAvailable.addEventListener("click", ()=>
{
    discountState = (discountState + 1) % 3;

switch (discountState)
{
    case 0 : showUnactive(); break;
    case 1 : showActive(); break;
    case 2 : showAll(); break;
}
});

function showAll()
{
    discountSearchAvailable.textContent = "Wyświetla wszystkie";
    discountSearchAvailable.classList.add("btn-info");
    discountSearchAvailable.classList.remove("btn-success");
    discountSearchAvailable.classList.remove("btn-danger");
}

function showActive()
{
    discountSearchAvailable.textContent = "Wyświetla aktywne";
    discountSearchAvailable.classList.add("btn-success");
    discountSearchAvailable.classList.remove("btn-danger");
}

function showUnactive()
{
    discountSearchAvailable.textContent = "Wyświetla nieaktywne";
    discountSearchAvailable.classList.add("btn-danger");
    discountSearchAvailable.classList.remove("btn-info");
}



const discounts = document.querySelectorAll(".discountList");
const discountsResetBtn = document.getElementById("discountResetBtn");

const discountSearchName = document.getElementById("discountSearchName");
const discountSearchMin = document.getElementById("discountSearchMin");
const discountSearchMax = document.getElementById("discountSearchMax");


function filterdiscounts()
{
    const nameValue = discountSearchName.value.toLowerCase();
    const minValue = parseFloat(discountSearchMin.value) || 0;
    const maxValue = parseFloat(discountSearchMax.value) || Infinity;

    discounts.forEach(discount => 
    {
        const discountName = discount.dataset.name;
        const discountPrice = discount.dataset.price;
        const discountActive = discount.dataset.available;

        const matchName = discountName.includes(nameValue);
        const matchPrice = discountPrice >= minValue && discountPrice <= maxValue;
        const matchAvailable = (Number(discountActive) === discountState || discountState == 2);

        if (matchName && matchPrice && matchAvailable)
        {
            discount.hidden = false;
        }
        else
        {
            discount.hidden = true;
        }
    });
}

discountSearchName.addEventListener("input", filterdiscounts);
discountSearchMin.addEventListener("input", filterdiscounts);
discountSearchMax.addEventListener("input", filterdiscounts);

discountSearchAvailable.addEventListener("click", filterdiscounts);

discountsResetBtn.addEventListener("click", () => 
{
    discountSearchName.value = "";
    discountSearchMin.value = "";
    discountSearchMax.value = "";
    discountState = 2;
    showAll();
    filterdiscounts();
});





const discountSelect = document.getElementById("discountSelect");

discountSelect.addEventListener("change", () => 
{
    const selected = discountSelect.options[discountSelect.selectedIndex];

    if (!selected.value) return;

    document.getElementById("discountId").value = selected.dataset.id || "";
    document.getElementById("discountName").value = selected.dataset.name || "";
    document.getElementById("discountPrice").value = selected.dataset.price || null;
    document.getElementById("discountStock").value = selected.dataset.stock || null;
    document.getElementById("discountDescription").value = selected.dataset.description || "";
    document.getElementById("discountImg").value = selected.dataset.img || "";
    document.getElementById("discountAvailable").checked = selected.dataset.available === "1";
});



const discountSaveBtn = document.getElementById("discountSaveBtn");
const discountAddBtn = document.getElementById("discountAddBtn");
const discountId = document.getElementById("discountId");
const discountIdNext = document.getElementById("discountIdNext");
const addSwitchValue = document.getElementById("addSwitchValue");

document.getElementById("discountAdd").addEventListener("change", ()=>
{
    discountAddBtn.classList.toggle("d-none");
    discountSaveBtn.classList.toggle("d-none");

    discountId.classList.toggle("d-none");
    discountIdNext.classList.toggle("d-none");

    addSwitchValue.value = addSwitchValue.value === "update" ? "add" : "update";
})