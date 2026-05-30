"use strict";

// Toggle filter panel visibility
const filterBtn = document.getElementById("filterBtn");
const filters   = document.getElementById("filters");

filterBtn.addEventListener("click", () => 
{
    filters.classList.toggle("filterDisabled");
});

// ── Filter elements ──────────────────────────────────────────
const products = document.querySelectorAll(".product");

// Text and price inputs
const filterName = document.getElementById("filterName");
const filterMin  = document.getElementById("filterMin");
const filterMax  = document.getElementById("filterMax");

// Availability toggle buttons (shop uses buttons, not checkboxes)
const filterIsAvailable   = document.getElementById("filterIsAvailable");
const filterIsActive      = document.getElementById("filterIsActive");
const filterIsDiscounted  = document.getElementById("filterIsDiscounted");

const filterIsUnavailable  = document.getElementById("filterIsUnavailable");
const filterIsUnactive     = document.getElementById("filterIsUnactive");
const filterIsUndiscounted = document.getElementById("filterIsUndiscounted");

// Category toggle buttons
const filterFood   = document.getElementById("filterFood");
const filterDrink  = document.getElementById("filterDrink");
const filterSchool = document.getElementById("filterSchool");

const resetFiltersBtn = document.getElementById("resetFiltersBtn");

// ── Main function ────────────────────────────────────────────
function filterProducts()
{
    const trueName = filterName.value.toLowerCase() || "";
    const trueMin  = parseFloat(filterMin.value) || 0;
    const trueMax  = parseFloat(filterMax.value) || Infinity;

    products.forEach(product => 
    {
        // Read data attributes set by productGenerate.php
        const productName  = product.dataset.name.toLowerCase();
        const productPrice = Number(product.dataset.price);
        const productType  = product.dataset.type;
        const productStock = Number(product.dataset.stock);

        // Product is available if marked available AND has stock (or unlimited stock = -1)
        const isAvailable  = Number(product.dataset.available) === 1 && (productStock === -1 || productStock > 0);
        const isActive     = Number(product.dataset.active);
        const isDiscounted = Number(product.dataset.discount);

        const matchName  = productName.includes(trueName);
        const matchPrice = productPrice >= trueMin && productPrice <= trueMax;

        const matchAvailable  = (filterIsAvailable.checked   && isAvailable)   || (filterIsUnavailable.checked  && !isAvailable);
        const matchActive     = (filterIsActive.checked       && isActive)      || (filterIsUnactive.checked     && !isActive);
        const matchDiscounted = (filterIsDiscounted.checked   && isDiscounted)  || (filterIsUndiscounted.checked && !isDiscounted);

        // Build array of active category filters; false entries are ignored by includes()
        const types =
        [
            filterFood.checked   && "food",
            filterDrink.checked  && "drink",
            filterSchool.checked && "school"
        ];

        const matchType = types.includes(productType);

        // "add" card is always visible regardless of filters
        if ((matchName && matchPrice && matchAvailable && matchActive && matchDiscounted && matchType) || product.dataset.action === "add")
        {
            product.parentElement.style.display = "block";
        } 
        else
        {
            product.parentElement.style.display = "none";
        }
    });
}

// ── Listeners ─────────────────────────────────────────────────
filterName.addEventListener("input", filterProducts);
filterMin .addEventListener("input", filterProducts);
filterMax .addEventListener("input", filterProducts);

filterIsAvailable.addEventListener("change",   filterProducts);
filterIsActive.addEventListener("change",      filterProducts);
filterIsDiscounted.addEventListener("change",  filterProducts);

filterIsUnavailable.addEventListener("change",  filterProducts);
filterIsUnactive.addEventListener("change",     filterProducts);
filterIsUndiscounted.addEventListener("change", filterProducts);

filterFood.addEventListener("change",   filterProducts);
filterDrink.addEventListener("change",  filterProducts);
filterSchool.addEventListener("change", filterProducts);

resetFiltersBtn.addEventListener("click", () => 
{
    resetFilters();
    filterProducts();
});

// ── Reset ─────────────────────────────────────────────────────
function resetFilters()
{
    filterName.value = "";
    filterMin.value  = "";
    filterMax.value  = "";

    // Restore all toggles to their default "show all" state
    filterIsAvailable.checked   = true;
    filterIsActive.checked      = true;
    filterIsDiscounted.checked  = true;

    filterIsUnavailable.checked  = true;
    filterIsUnactive.checked     = true;
    filterIsUndiscounted.checked = true;

    filterFood.checked   = true;
    filterDrink.checked  = true;
    filterSchool.checked = true;
}