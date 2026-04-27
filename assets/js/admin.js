"use strict";

const productSelect = document.getElementById("productSelect");

productSelect.addEventListener("change", () => 
{
    const selected = productSelect.options[productSelect.selectedIndex];

    if (!selected.value) return;

    document.getElementById("id").value = selected.dataset.id || "";
    document.getElementById("name").value = selected.dataset.name || "";
    document.getElementById("description").value = selected.dataset.description || "";
    document.getElementById("price").value = selected.dataset.price || "";
    document.getElementById("stock").value = selected.dataset.stock || "";
    document.getElementById("img").value = selected.dataset.img || "";

    document.getElementById("is_available").checked =
        selected.dataset.available == "1";
});