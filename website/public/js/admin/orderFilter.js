"use strict";

// Toggle filter panel visibility
const filterBtn = document.getElementById("filterBtn");
const filters   = document.getElementById("filters");

filterBtn.addEventListener("click", () =>
{
    filters.classList.toggle("filterDisabled");
});

// ── elementy filtrów ──────────────────────────────────────────
const cards       = document.querySelectorAll('.order-card');
const noMsg       = document.getElementById('noOrdersMsg');
const searchInput = document.getElementById('searchInput');
const filterMin   = document.getElementById('filterMin');
const filterMax   = document.getElementById('filterMax');
const statusCBs   = document.querySelectorAll('.status-filter'); // dynamically generated from $statusLabels in PHP
const resetBtn    = document.getElementById('resetFilters');

// ── główna funkcja ────────────────────────────────────────────
function applyFilters()
{
    const text   = searchInput.value.toLowerCase().trim();
    const min    = filterMin.value !== '' ? parseFloat(filterMin.value) : null;
    const max    = filterMax.value !== '' ? parseFloat(filterMax.value) : null;

    // Collect all currently checked status values
    const active = [...statusCBs].filter(cb => cb.checked).map(cb => cb.value);

    let visible = 0;

    cards.forEach(card =>
    {
        const { status, name, email, orderid, price } = card.dataset;
        const numPrice = parseFloat(price);

        const matchStatus = active.includes(status);
        const matchText   = !text || name.includes(text) || email.includes(text) || orderid.includes(text);
        const matchMin    = min === null || numPrice >= min;
        const matchMax    = max === null || numPrice <= max;

        const show = matchStatus && matchText && matchMin && matchMax;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    // Show "no results" message when nothing passes the filters
    noMsg.style.display = visible === 0 ? 'block' : 'none';
}

// ── reset ─────────────────────────────────────────────────────
function resetFilters()
{
    searchInput.value = '';
    filterMin.value   = '';
    filterMax.value   = '';

    // Re-check all status checkboxes
    statusCBs.forEach(cb => { cb.checked = true; });

    applyFilters();
}

// ── listenery ─────────────────────────────────────────────────
searchInput.addEventListener('input',  applyFilters);
filterMin  .addEventListener('input',  applyFilters);
filterMax  .addEventListener('input',  applyFilters);
statusCBs  .forEach(cb => cb.addEventListener('change', applyFilters));
resetBtn   .addEventListener('click',  resetFilters);