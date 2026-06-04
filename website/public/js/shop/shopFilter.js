"use strict";

// Client-side product filtering by name, price, type and availability

const filterBtn = document.getElementById("filterBtn");
const filters = document.getElementById("filters");

// Toggles filter panel visibility
filterBtn.addEventListener("click", () => 
{
    filters.classList.toggle("filterDisabled");
});



const products = document.querySelectorAll(".product");

const filterName = document.getElementById("filterName");
const filterMin = document.getElementById("filterMin");
const filterMax = document.getElementById("filterMax");

const filterIsAvailable = document.getElementById("filterIsAvailable");
const filterIsDiscounted = document.getElementById("filterIsDiscounted");
let includeAvailable = false;
let includeDiscounted = false;

const filterFood = document.getElementById("filterFood");
const filterDrink = document.getElementById("filterDrink");
const filterSchool = document.getElementById("filterSchool");
let includeFood = false;
let includeDrink = false;
let includeSchool = false;

const resetFiltersBtn = document.getElementById("resetFiltersBtn");


// Toggles availability filter
filterIsAvailable.addEventListener("click", ()=>
{
    filterIsAvailable.classList.toggle("opacity-50");
    includeAvailable = !includeAvailable;
})

// Toggles discount filter
filterIsDiscounted.addEventListener("click", ()=>
{
    filterIsDiscounted.classList.toggle("opacity-50");
    includeDiscounted = !includeDiscounted;
})


// Toggles food/drink/school category filters
filterFood.addEventListener("click", ()=>
{
    filterFood.classList.toggle("opacity-50");
    includeFood = !includeFood;
})
filterDrink.addEventListener("click", ()=>
{
    filterDrink.classList.toggle("opacity-50");
    includeDrink = !includeDrink;
})
filterSchool.addEventListener("click", ()=>
{
    filterSchool.classList.toggle("opacity-50");
    includeSchool = !includeSchool;
})



function filterProducts()
{
    const trueName = filterName.value.toLowerCase() || "";
    const trueMin = parseFloat(filterMin.value) || 0;
    const trueMax = parseFloat(filterMax.value) || Infinity;

    products.forEach(product => 
    {
        const productName = product.dataset.name.toLowerCase();
        const productPrice = Number(product.dataset.price);
        const productType = product.dataset.type;
        const productStock = Number(product.dataset.stock);
        const isAvailable = Number(product.dataset.available) === 1 && (productStock === -1 || productStock > 0);
        const isDiscounted = Number(product.dataset.discount);

        const matchName = productName.includes(trueName);
        const matchPrice = productPrice >= trueMin && productPrice <= trueMax;

        // Build list of selected types; empty means all types match
        const typesSelected = [];
        if (includeFood) typesSelected.push("food");
        if (includeDrink) typesSelected.push("drink");
        if (includeSchool) typesSelected.push("school");

        const matchType = typesSelected.length === 0 || typesSelected.includes(productType);

        const matchAvailable = !includeAvailable || isAvailable;
        const matchDiscount = !includeDiscounted || isDiscounted;

        if (matchName && matchPrice && matchType && matchAvailable && matchDiscount)
        {
            product.parentElement.style.display = "block";
        } 
        else
        {
            product.parentElement.style.display = "none";
        }
    });
}

// Re-run filter on every input change
filterName.addEventListener("input", filterProducts);
filterMin.addEventListener("input", filterProducts);
filterMax.addEventListener("input", filterProducts);

filterIsAvailable.addEventListener("click", filterProducts);
filterIsDiscounted.addEventListener("click", filterProducts);

filterFood.addEventListener("click", filterProducts);
filterDrink.addEventListener("click", filterProducts);
filterSchool.addEventListener("click", filterProducts);

// Resets all filters and re-runs filtering
resetFiltersBtn.addEventListener("click", () => 
{
    resetFilters();
    filterProducts();
});

function resetFilters()
{
    filterName.value = "";
    filterMin.value = "";
    filterMax.value = "";

    includeAvailable = false;
    includeDiscounted = false;
    includeFood = false;
    includeDrink = false;
    includeSchool = false;

    filterIsAvailable.classList.add("opacity-50");
    filterIsDiscounted.classList.add("opacity-50");
    filterFood.classList.add("opacity-50");
    filterDrink.classList.add("opacity-50");
    filterSchool.classList.add("opacity-50");
}