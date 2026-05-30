"use strict";

const filterBtn = document.getElementById("filterBtn");
const filters   = document.getElementById("filters");

filterBtn.addEventListener("click", () => {
    filters.classList.toggle("filterDisabled");
});

// ── elementy filtrów ──────────────────────────────────────────
const discounts = document.querySelectorAll(".product");

const filterMin = document.getElementById("filterMin");        // min %
const filterMax = document.getElementById("filterMax");        // max %

const filterActive = document.getElementById("filterIsActive");       // aktywna teraz
const filterFuture = document.getElementById("filterIsAvailable");    // przyszła
const filterExpired = document.getElementById("filterIsUnavailable");  // wygasła

const resetFiltersBtn  = document.getElementById("resetFiltersBtn");

// ── główna funkcja ────────────────────────────────────────────
function filterDiscounts() {
    const trueMin = parseFloat(filterMin.value) || 0;
    const trueMax = parseFloat(filterMax.value) || Infinity;

    const now = new Date();

    discounts.forEach(discount => {
        // karta "dodaj" zawsze widoczna
        if (discount.dataset.action === "add") {
            discount.parentElement.style.display = "block";
            return;
        }

        const procent   = parseInt(discount.dataset.procent);
        const isActive  = discount.dataset.active === "1";
        const startDate = new Date(discount.dataset.start);
        const endDate   = new Date(discount.dataset.end);

        const isFuture  = !isActive && startDate > now;
        const isExpired = !isActive && endDate   < now;

        // filtr procentu (reużywamy pola min/max)
        const matchProcent = procent >= trueMin && procent <= trueMax;

        // filtr statusu
        const matchStatus =
            (filterActive.checked  && isActive)  ||
            (filterFuture.checked  && isFuture)  ||
            (filterExpired.checked && isExpired);

        discount.parentElement.style.display =
            (matchProcent && matchStatus) ? "block" : "none";
    });
}

// ── listenery ─────────────────────────────────────────────────
filterMin.addEventListener("input",  filterDiscounts);
filterMax.addEventListener("input",  filterDiscounts);
filterActive.addEventListener("change",  filterDiscounts);
filterFuture.addEventListener("change",  filterDiscounts);
filterExpired.addEventListener("change", filterDiscounts);

resetFiltersBtn.addEventListener("click", () => {
    resetFilters();
    filterDiscounts();
});

function resetFilters() {
    filterMin.value = "";
    filterMax.value = "";
    filterActive.checked  = true;
    filterFuture.checked  = true;
    filterExpired.checked = true;
}