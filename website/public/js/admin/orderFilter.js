"use strict";

const filterBtn = document.getElementById("filterBtn");
const filters   = document.getElementById("filters");

filterBtn.addEventListener("click", () =>
{
    filters.classList.toggle("filterDisabled");
});

const cards       = document.querySelectorAll('.order-card');
const noMsg       = document.getElementById('noOrdersMsg');
const searchInput = document.getElementById('searchInput');
const filterMin   = document.getElementById('filterMin');
const filterMax   = document.getElementById('filterMax');
const statusCBs   = document.querySelectorAll('.status-filter');
const resetBtn    = document.getElementById('resetFilters');

function applyFilters()
{
    const text   = searchInput.value.toLowerCase().trim();
    const min    = filterMin.value !== '' ? parseFloat(filterMin.value) : null;
    const max    = filterMax.value !== '' ? parseFloat(filterMax.value) : null;
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

    noMsg.style.display = visible === 0 ? 'block' : 'none';
}

function resetFilters()
{
    searchInput.value = '';
    filterMin.value   = '';
    filterMax.value   = '';
    statusCBs.forEach(cb => { cb.checked = true; });
    applyFilters();
}

searchInput.addEventListener('input',  applyFilters);
filterMin  .addEventListener('input',  applyFilters);
filterMax  .addEventListener('input',  applyFilters);
statusCBs  .forEach(cb => cb.addEventListener('change', applyFilters));
resetBtn   .addEventListener('click',  resetFilters);