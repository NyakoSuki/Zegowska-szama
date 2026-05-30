"use strict";

const filterBtn = document.getElementById("filterBtn");
const filters   = document.getElementById("filters");

filterBtn.addEventListener("click", () =>
{
    filters.classList.toggle("filterDisabled");
});

// ── elementy filtrów ──────────────────────────────────────────
const cards = document.querySelectorAll(".user-card");
const noMsg = document.getElementById("noUsersMsg");

const searchInput    = document.getElementById("searchInput");
const filterAdmin    = document.getElementById("f_admin");
const filterUser     = document.getElementById("f_user");
const filterActive   = document.getElementById("f_active");
const filterInactive = document.getElementById("f_inactive");
const resetFiltersBtn = document.getElementById("resetFilters");

// ── główna funkcja ────────────────────────────────────────────
function applyFilters()
{
    const text = searchInput.value.toLowerCase().trim();

    let visible = 0;

    cards.forEach(card =>
    {
        const matchRole = (filterAdmin.checked   && card.dataset.role   === "admin")
                       || (filterUser.checked    && card.dataset.role   === "user");

        const matchActive = (filterActive.checked   && card.dataset.active === "1")
                         || (filterInactive.checked && card.dataset.active === "0");

        const matchText = !text || card.dataset.search.includes(text);

        const show = matchRole && matchActive && matchText;
        card.style.display = show ? "" : "none";
        if (show) visible++;
    });

    noMsg.style.display = visible === 0 ? "block" : "none";
}

// ── listenery ─────────────────────────────────────────────────
searchInput.addEventListener("input",   applyFilters);
filterAdmin.addEventListener("change",  applyFilters);
filterUser.addEventListener("change",   applyFilters);
filterActive.addEventListener("change", applyFilters);
filterInactive.addEventListener("change", applyFilters);

resetFiltersBtn.addEventListener("click", () =>
{
    resetFilters();
    applyFilters();
});

// ── reset ─────────────────────────────────────────────────────
function resetFilters()
{
    searchInput.value      = "";
    filterAdmin.checked    = true;
    filterUser.checked     = true;
    filterActive.checked   = true;
    filterInactive.checked = true;
}